<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 1/4/18
 * Time: 5:02 PM
 */

namespace Aragorn\JobManager\Controller\Index;

use Magento\Framework\App\Action;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\DirectoryList;
use Aragorn\JobManager\Model\ApplicantFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\App\ObjectManager;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Aragorn\JobManager\Mail\Template\TransportBuilder;
use Aragorn\JobManager\Model\JobRepository;

class ApplyPost extends Action\Action
{
    /**
     * @var DirectoryList
     */
    protected $directoryList;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var ApplicantFactory
     */
    protected $applicantFactory;
    /**
     * @var File
     */
    protected $file;
    /**
     * @var Filesystem\Driver\File
     */
    protected $reader;
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    protected $destinationFolder;
    /**
     * @var JobRepository
     */
    protected $jobRepository;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlModel;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistorInterface;

    /**
     * @var mixed
     */
    protected $formKeyValidator;

    /**
     * ApplyPost constructor.
     * @param Action\Context $context
     * @param DirectoryList $directoryList
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param ApplicantFactory $applicantFactory
     * @param Filesystem\Io\File $file
     * @param Filesystem\Driver\File $reader
     * @param Filesystem $filesystem
     * @param JobRepository $jobRepository
     * @param UrlFactory $urlFactory
     * @param DataPersistorInterface $dataPersistorInterface
     * @param Validator|null $formKeyValidator
     */
    public function __construct(
        Action\Context $context,
        DirectoryList $directoryList,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        StateInterface $inlineTranslation,
        TransportBuilder $transportBuilder,
        ApplicantFactory $applicantFactory,
        Filesystem\Io\File $file,
        Filesystem\Driver\File $reader,
        Filesystem $filesystem,
        JobRepository $jobRepository,
        UrlFactory $urlFactory,
        DataPersistorInterface $dataPersistorInterface,
        Validator $formKeyValidator = null
    )
    {
        parent::__construct($context);
        $this->directoryList = $directoryList;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->applicantFactory = $applicantFactory;
        $this->file = $file;
        $this->reader = $reader;
        $this->fileSystem = $filesystem;
        $this->jobRepository = $jobRepository;
        $this->urlModel = $urlFactory->create();
        $this->dataPersistorInterface = $dataPersistorInterface;
        $this->formKeyValidator = $formKeyValidator ?: ObjectManager::getInstance()->get(Validator::class);
    }

    /**
     * Dispatch request
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        if (!$this->getRequest()->isPost() || !$this->formKeyValidator->validate($this->getRequest())) {
            $url = $this->urlModel->getUrl('job', ['_secure' => true]);
            $resultRedirect->setUrl($this->_redirect->error($url));
            return $resultRedirect;
        }

        // Handle Form Post
        $postData = (array)$this->getRequest()->getPostValue();

        if (!empty($postData)) {
            $job_id = !empty($this->getRequest()->getParam('id')) ? $this->getRequest()->getParam('id') : '';

            // Handle File Operations
            $this->destinationFolder = $this->directoryList->getPath('media') . '/jobmanager/';

            if (!file_exists($this->destinationFolder)) {
                $this->file->mkdir($this->directoryList->getPath('media') . '/jobmanager', 0775);
            } else {
                list($cv, $coverLetter) = $this->handleFileOperations();

                if (!is_null($cv) && !is_null($coverLetter)) {
                    $data = $this->prepareData($postData, $job_id, $cv, $coverLetter);

                    // Save to database
                    $this->save($data);

                    return $resultRedirect->setPath('job');
                } else {
                    $this->dataPersistorInterface->set('form_data', $postData);

                    return $resultRedirect->setUrl($this->_redirect->error($this->urlModel->getUrl('*/*/apply/id/' . $job_id)));
                }

            }

        }

    }

    /**
     * Type Check for uploaded files and moves the file
     * @return array
     */
    public function handleFileOperations()
    {
        // type check
        $allowed = array('doc', 'docx', 'pdf', 'jpg', 'png');
        // cv
        $cv = $this->uploadCV($allowed);
        // cover letter
        $coverLetter = $this->uploadCoverLetter($allowed);

        return array($cv, $coverLetter);
    }

    /**
     * Sends Email
     * @param $data
     */
    public function sendEmail($data)
    {

        $from = array('email' => $this->scopeConfig->getValue(
            'jobmanager_email/email/applicant_admin_sender_email', ScopeInterface::SCOPE_STORE
        ), 'name' => $this->scopeConfig->getValue(
            'jobmanager_email/email/applicant_admin_sender_name', ScopeInterface::SCOPE_STORE
        ));
        $templateOptions = array(
            'area' => Area::AREA_FRONTEND,
            'store' => $this->storeManager->getStore()->getId());


        $this->inlineTranslation->suspend();
        $adminto = $this->scopeConfig->getValue(
            'jobmanager_email/email/applicant_admin_receiver_email', ScopeInterface::SCOPE_STORE
        );

        $transport = $this->transportBuilder
            ->addAttachment(
                $this->reader->fileGetContents($this->destinationFolder . $data['cv']),
                $_FILES['cv']['type'],
                $_FILES['cv']['name']

            )
            ->addAttachment(
                $this->reader->fileGetContents($this->destinationFolder . $data['cover_letter']),
                $_FILES['letter']['type'],
                $_FILES['letter']['name']

            )
            ->setTemplateIdentifier('jobmanager_new_applicant_email')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($data)
            ->setFrom($from)
            ->addTo($adminto)
            ->getTransport();

        $transport->sendMessage();
        $this->inlineTranslation->resume();
    }

    /**
     * Upload Cover Letter
     * @param $allowed
     * @return mixed
     */
    public function uploadCoverLetter($allowed)
    {
        if ($_FILES){
            if (in_array(pathinfo($_FILES['letter']['name'], PATHINFO_EXTENSION), $allowed)) {
                $name = explode('.', $_FILES['letter']['name'])[0];
                $extension = '.' . explode('.', $_FILES['cv']['name'])[1];
                $coverLetterFilename = $name . '_' . rand(0, 100) . strtotime(date("Y-m-d h:i:sa")) . $extension;
                move_uploaded_file($_FILES['letter']['tmp_name'], $this->destinationFolder . $coverLetterFilename);
                $coverLetter = $coverLetterFilename;
            } else {
                $this->messageManager->addErrorMessage('The file type is not supported. Please try again.');
            }
        }


        return isset($coverLetter) ? $coverLetter : null;
    }

    /**
     * Upload CV
     * @param $allowed
     * @return mixed
     */
    public function uploadCV($allowed)
    {

        if ($_FILES) {
            if (in_array(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION), $allowed)) {
                $name = explode('.', $_FILES['cv']['name'])[0];
                $extension = '.' . explode('.', $_FILES['cv']['name'])[1];
                $cvFilename = $name . '_' . rand(0, 100) . strtotime(date("Y-m-d h:i:sa")) . $extension;
                move_uploaded_file($_FILES['cv']['tmp_name'], $this->destinationFolder . $cvFilename);
                $cv = $cvFilename;
            } else {

                $this->messageManager->addErrorMessage('The file type is not supported. Please try again.');
            }
        }

        return isset($cv) ? $cv : null;
    }

    /**
     * @param $postData
     * @param $job_id
     * @param $cv
     * @param $coverLetter
     * @return array
     */
    public function prepareData($postData, $job_id, $cv, $coverLetter)
    {
        $data = [
            'email' => $postData['email'],
            'job_id' => ($job_id) ? $job_id : null,
            'country' => $postData['country'],
            'firstname' => $postData['first_name'],
            'lastname' => $postData['last_name'],
            'phone' => $postData['phone'],
            'address' => $postData['address'],
            'zip_code' => $postData['zip_code'],
            'city' => $postData['city'],
            'cv' => $cv,
            'cover_letter' => $coverLetter,
        ];
        return $data;
    }

    /**
     * @param $data
     */
    public function save($data)
    {
        $model = $this->applicantFactory->create();
        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccessMessage(__('Your Application has been submitted'));

            // Add Job Position to $data to be used in email template
            $data['position'] = $this->getJobPosition($this->getRequest()->getParam('id'));

            // send email
            $this->sendEmail($data);

        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong. Please try again'));
        }
    }


    /**
     * @param $id
     * @return null|string
     */
    public function getJobPosition($id)
    {
        if ($id) {
            return $this->jobRepository->getById($id)->getPosition() ? $this->jobRepository->getById($id)->getPosition() : __('General Application');
        } else {
            return __('General Application');
        }

    }
}