<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/17/17
 * Time: 12:04 PM
 */

namespace Aragorn\JobManager\Block\Index;

use Magento\Framework\View\Element\Template;
use Aragorn\JobManager\Model\JobRepository;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\Http;

class JobDetail extends Template
{
    /**
     * @var JobRepository
     */
    protected $jobRepository;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    protected $request;

    /**
     * JobDetail constructor.
     * @param Template\Context $context
     * @param JobRepository $jobRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        JobRepository $jobRepository,
         StoreManagerInterface $storeManager,
         Http $request,
         array $data = []
    )
    {
        parent::__construct($context);
        $this->jobRepository = $jobRepository;
        $this->storeManager = $storeManager;
        $this->request = $request;
    }

    /**
     * Retrieves Job for specified id
     * @return bool|\Aragorn\JobManager\Api\Data\JobInterface|\Aragorn\JobManager\Model\Job
     */
    public function getJobDetail()
    {
        $id = $this->getRequest()->getParam('id');
        $jobDetail = $this->jobRepository->getById($id);
        
        if ( !is_null( $id ) ) {
            return $jobDetail;
        }

        return false;
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
}