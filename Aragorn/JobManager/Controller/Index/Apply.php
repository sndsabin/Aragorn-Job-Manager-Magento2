<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/17/17
 * Time: 2:56 PM
 */

namespace Aragorn\JobManager\Controller\Index;


use Aragorn\JobManager\Controller\Job;
use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;
use Aragorn\JobManager\Model\JobRepository;


class Apply extends Job
{

    /**
     * @var JobRepository
     */
    protected $jobRepository;


    /**
     * Apply constructor.
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     * @param JobRepository $jobRepository
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        JobRepository $jobRepository
    )
    {
        parent::__construct($context, $resultPageFactory);
        $this->jobRepository = $jobRepository;
    }

    /**
     * Dispatch request
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        //Dynamic Breadcrumb creation
        $resultPage = $this->createBreadCrumb();

        return $resultPage;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function createBreadCrumb()
    {
        $resultPage = $this->resultPageFactory->create();
        $id = $this->getRequest()->getParam('id');
        $jobPosition = 'General Application';
        if ($id) {
            $jobPosition = $this->getJobPosition($id);
        }
        $breadcrumbs = $resultPage->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb($jobPosition, array(
            "label" => $jobPosition,
            "title" => $jobPosition,
        ));


        return $resultPage;
    }

    /**
     * @param $id
     * @return null|string
     */
    public function getJobPosition($id)
    {
        return $this->jobRepository->getById($id)->getPosition() ? $this->jobRepository->getById($id)->getPosition() : __('General Application') ;
    }

}