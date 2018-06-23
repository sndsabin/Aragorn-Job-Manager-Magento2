<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/16/17
 * Time: 4:43 PM
 */

namespace Aragorn\JobManager\Controller\Index;

use Aragorn\JobManager\Controller\Job;
use Aragorn\JobManager\Model\JobRepository;

class Detail extends Job
{
     /**
     * @var JobRepository
     */
    protected $jobRepository;

    /**
     * Detail constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param JobRepository $jobRepository
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
            \Magento\Framework\View\Result\PageFactory $resultPageFactory,
            JobRepository $jobRepository) {
        parent::__construct($context, $resultPageFactory);
        $this->jobRepository = $jobRepository;
    }

    /**
     * Dispatch Request
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        $resultPage = $this->resultPageFactory->create();
        $jobDetail = $this->jobRepository->getById($this->getRequest()->getParam('id'));
        $breadcrumbs =  $resultPage->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb($jobDetail->getPosition(), array(
            "label" => $jobDetail->getPosition(),
            "title" => $jobDetail->getPosition(),
       ));

        return $resultPage;
        
    }

}