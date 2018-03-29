<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/15/17
 * Time: 3:18 PM
 */

namespace Aragorn\JobManager\Block\Index;

use Aragorn\JobManager\Api\Data\JobInterface;
use Magento\Framework\View\Element\Template;
use Aragorn\JobManager\Model\ResourceModel\Job\CollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

class JobList extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $jobCollectionFactory;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var int
     */
    protected $pageSize;

    protected $storeManager;


    /**
     * JobList constructor.
     * @param Template\Context $context
     * @param CollectionFactory $postCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $jobCollectionFactory,
        array $data = [],
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->jobCollectionFactory = $jobCollectionFactory;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Returns Job Collection Factory
     * InnerJoin with Store
     * @return \Aragorn\JobManager\Model\ResourceModel\Job\Collection
     */
    private function createInnerJoinedAndFilteredJobCollectionFactory()
    {
        $jobs = $this->jobCollectionFactory->create();

        $jobs->join(
            ['aragorn_jobmanager_job_store' => $jobs->getTable('aragorn_jobmanager_job_store')],
            'main_table.job_id = aragorn_jobmanager_job_store.job_id',
            '*'
        )
            ->addFieldToFilter(
                'store_id',
                [$this->getCurrentStore(), 0]
            );
        return $jobs;
    }

    /**
     * Retrieves all jobs
     * @return mixed
     */
    public function getJobs()
    {
        $page = ($this->getRequest()->getParam('p')) ? $this->getRequest()->getParam('p') : 1;
        $this->pageSize = $this->getPageSize() ? $this->getPageSize() : 4;

        if (!$this->hasData('jobs')) {
            $jobs = $this->createInnerJoinedAndFilteredJobCollectionFactory()
                ->addOrder(
                    JobInterface::CREATED_AT
                )
                ->setPageSize($this->pageSize)
                ->setCurPage($page);


            if (!$this->listClosedJobs()) {
                $jobs->addFilter('status', 1);
            }

            $this->setData('jobs', $jobs);
        }
        return $this->getData('jobs');
    }

    /**
     * Checks if the job with closed status is to be listed
     * @return bool|mixed
     */
    public function listClosedJobs()
    {
        $isClosedJobsToBeListed = $this->scopeConfig->getValue(
            'jobmanager_view/view/list_closed_jobs', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return (bool)$isClosedJobsToBeListed ? $isClosedJobsToBeListed : false;
    }

    public function getPageSize()
    {
        $pageSize = $this->scopeConfig->getValue(
            'jobmanager_view/view/page_size', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return ($pageSize > 0) ? $pageSize : 4;
    }

    /**
     * Prepares layout for default pagination
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        if ($this->getJobs()) {
            $pager = $this->getLayout()
                ->createBlock('Magento\Theme\Block\Html\Pager', 'jobsmanager.jobs.pager')
                ->setShowPerPage(false)
                ->setShowAmounts(false)
                ->setLimit($this->pageSize)
                ->setCollection($this->getJobs());

            $this->setChild('pager', $pager);
            $this->getJobs()->load();

            return $this;
        }
    }

    /**
     * Returns Pagination View
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * Check if the ajax pagination is enabled
     * @return bool|mixed
     */
    public function isAjaxPaginationEnabled()
    {
        $isEnabled = $this->scopeConfig->getValue(
            'jobmanager_view/view/enable_ajax_pagination', \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        return (bool)$isEnabled ? $isEnabled : false;
    }

    /**
     * Retrieves total page no
     * @return int
     */
    public function getTotalPageNo()
    {
        $totalRecords = $this->createInnerJoinedAndFilteredJobCollectionFactory()->count();

        return (int)ceil($totalRecords / $this->pageSize);
    }

    /**
     * Retrieves Current Page No from request
     * @return int|mixed
     */
    public function getCurrentPage()
    {
        return $this->getRequest()->getParam('p') ? $this->getRequest()->getParam('p') : 1;
    }

    /**
     * Get Current Store
     * @return mixed
     */
    public function getCurrentStore()
    {
        return $this->storeManager->getStore()->getId();
    }
}
