<?php
/**
 * A Magento 2 module named Aragorn/JobManager
 * Copyright (C) 2017  
 * 
 * This file is part of Aragorn/JobManager.
 * 
 * Aragorn/JobManager is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Aragorn\JobManager\Model;

use Aragorn\JobManager\Api\Data\JobInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Aragorn\JobManager\Model\ResourceModel\Job as ResourceJob;
use Aragorn\JobManager\Api\Data\JobSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SortOrder;
use Aragorn\JobManager\Api\JobRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Aragorn\JobManager\Model\ResourceModel\Job\CollectionFactory as JobCollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Aragorn\JobManager\Api\Data\JobInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;

class JobRepository implements jobRepositoryInterface
{
    /**
     * @var ResourceJob
     */
    protected $resource;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var JobCollectionFactory
     */
    protected $jobCollectionFactory;
    /**
     * @var JobInterfaceFactory
     */
    protected $dataJobFactory;
    /**
     * @var JobSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var JobFactory
     */
    protected $jobFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;


    /**
     * @param ResourceJob $resource
     * @param JobFactory $jobFactory
     * @param JobInterfaceFactory $dataJobFactory
     * @param JobCollectionFactory $jobCollectionFactory
     * @param JobSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceJob $resource,
        JobFactory $jobFactory,
        JobInterfaceFactory $dataJobFactory,
        JobCollectionFactory $jobCollectionFactory,
        JobSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->jobFactory = $jobFactory;
        $this->jobCollectionFactory = $jobCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataJobFactory = $dataJobFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * Save Job Data
     *
     * @param JobInterface $job
     * @return JobInterface
     * @throws CouldNotSaveException
     */
    public function save(
        JobInterface $job
    ) {

        if (empty($job->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $job->setStoreId($storeId);
        }

        try {
            $job->getResource()->save($job);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the job: %1',
                $exception->getMessage()
            ));
        }
        return $job;
    }

    /**
     * Load Job data by given job Identity
     *
     * @param string $jobId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($jobId)
    {
        $job = $this->jobFactory->create();
        $job->getResource()->load($job, $jobId);
        if (!$job->getId()) {
            throw new NoSuchEntityException(__('Job with id "%1" does not exist.', $jobId));
        }
        return $job;
    }

    /**
     * Load Job data collection by given search criteria
     * @param SearchCriteriaInterface $criteria
     * @return mixed
     */
    public function getList(
        SearchCriteriaInterface $criteria
    ) {
        $collection = $this->jobCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * Delete Job
     * @param JobInterface $job
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(
        JobInterface $job
    ) {
        try {
            $job->getResource()->delete($job);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Job: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete Job by given Job Identity
     * @param string $jobId
     * @return bool
     */
    public function deleteById($jobId)
    {
        return $this->delete($this->getById($jobId));
    }
}
