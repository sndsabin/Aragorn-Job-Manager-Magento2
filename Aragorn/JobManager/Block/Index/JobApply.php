<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/17/17
 * Time: 2:57 PM
 */

namespace Aragorn\JobManager\Block\Index;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;

use Aragorn\JobManager\Model\JobRepository;

class JobApply extends Template
{

    /**
     * @var CollectionFactory
     */
    protected $countryCollectionFactory;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Http
     */
    protected $request;
    /**
     * @var JobRepository
     */
    protected $jobRepository;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistorInterface;


    /**
     * JobApply constructor.
     * @param Context $context
     * @param array $data
     * @param CollectionFactory $countryCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param Http $request
     * @param JobRepository $jobRepository
     * @param StoreManagerInterface $storeManager
     * @param DataPersistorInterface $dataPersistorInterface
     */
    public function __construct(
        Context $context,
        array $data = [],
        CollectionFactory $countryCollectionFactory,
        ScopeConfigInterface $scopeConfig,
        Http $request,
        JobRepository $jobRepository,
        StoreManagerInterface $storeManager,
        DataPersistorInterface $dataPersistorInterface
    )
    {
        parent::__construct($context, $data);
        $this->countryCollectionFactory = $countryCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->jobRepository = $jobRepository;
        $this->storeManager = $storeManager;
        $this->dataPersistorInterface = $dataPersistorInterface;
    }

    /**
     * Retrieve Form Action
     * @return string
     */
    public function getFormAction()
    {
        $jobId = $this->getRequest()->getParam('id');
        return (string)$this->getUrl('job/index/applypost/id/'. $jobId, ['_secure' => true]);
    }

    /**
     * Retrieves Country List
     * @return array
     */
    public function getCountriesList()
    {
        return $this->countryCollectionFactory->create()->toOptionArray();
    }

    /**
     * Retrieves Linkedin API Key saved in System Configuration
     * @return string
     */
    public function getLinkedInAPIKey()
    {
        return $this->scopeConfig->getValue(
            'jobmanager_linkedin/api/linkedin_api_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Return Job Title for specified Id in request
     * @return \Magento\Framework\Phrase|mixed|null|string|void
     */
    public function getJobTitle() {
        $id =  $this->request->getParam('id'); 
        return $id ? $this->jobRepository->getById($id)->getPosition() : __('General Application');
    }

    /**
     * Check if the deadline is not over
     * Returns True for General Application
     * @return bool
     */
    public function isDeadlineNotOver() {
        $id =  $this->request->getParam('id');

        if ($id) {
            $deadline = $this->jobRepository->getById($id)->getDeadline();
            $difference = strtotime($deadline) - strtotime(date('Y-m-d h:i:sa'));

            return ($difference >= 0) ? true : false;
        }

        return true;
    }

    /**
     * Check if the job status is open
     * Returns True for General Application
     * @return bool
     */
    public function isStatusOpen()
    {
        $id =  $this->request->getParam('id');

        if ($id) {
            $status = $this->jobRepository->getById($id)->getStatus();
            
            return $status == 'Open';
        }

        return true;
    }

    /**
     * Retrieves Posted Form Value from core registry
     * @return mixed
     */
    public function getPostedValue()
    {

        $data = $this->dataPersistorInterface->get('form_data');
        // unset
        $this->dataPersistorInterface->clear('form_data');

        return $data;

    }

    /**
     * Returns all the stores which specified job is associated with
     * @return int[]
     */
    public function getStores()
    {
        $id =  $this->request->getParam('id');
        $storesJobisAssociatedWith = [];

        if ($id) {
            $storesJobisAssociatedWith = $this->jobRepository->getById($id)->getStores();
        }

        return $storesJobisAssociatedWith;
    }

    /**
     * Get Current Store
     * @return int
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * Prepares layout and set the title
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set($this->getJobTitle());

        return parent::_prepareLayout();
    }

}