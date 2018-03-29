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

use Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Aragorn\JobManager\Api\Data\Applicant\ApplicantSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Aragorn\JobManager\Model\ResourceModel\Applicant as ResourceApplicant;
use Magento\Framework\Api\SortOrder;
use Aragorn\JobManager\Api\ApplicantRepositoryInterface;
use Magento\Framework\Api\DataObjectHelper;
use Aragorn\JobManager\Api\Data\Applicant\ApplicantInterfaceFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Aragorn\JobManager\Model\ResourceModel\Applicant\CollectionFactory as ApplicantCollectionFactory;

class ApplicantRepository implements applicantRepositoryInterface
{

    protected $resource;

    protected $dataObjectProcessor;

    private $storeManager;

    protected $applicantFactory;

    protected $searchResultsFactory;

    protected $applicantCollectionFactory;

    protected $dataApplicantFactory;

    protected $dataObjectHelper;


    /**
     * @param ResourceApplicant $resource
     * @param ApplicantFactory $applicantFactory
     * @param ApplicantInterfaceFactory $dataApplicantFactory
     * @param ApplicantCollectionFactory $applicantCollectionFactory
     * @param ApplicantSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceApplicant $resource,
        ApplicantFactory $applicantFactory,
        ApplicantInterfaceFactory $dataApplicantFactory,
        ApplicantCollectionFactory $applicantCollectionFactory,
        ApplicantSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    )
    {
        $this->resource = $resource;
        $this->applicantFactory = $applicantFactory;
        $this->applicantCollectionFactory = $applicantCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataApplicantFactory = $dataApplicantFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        ApplicantInterface $applicant
    )
    {
        try {
            $applicant->getResource()->save($applicant);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the applicant: %1',
                $exception->getMessage()
            ));
        }
        return $applicant;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($applicantId)
    {
        $applicant = $this->applicantFactory->create();
        $applicant->getResource()->load($applicant, $applicantId);
        if (!$applicant->getId()) {
            throw new NoSuchEntityException(__('Applicant with id "%1" does not exist.', $applicantId));
        }
        return $applicant;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        SearchCriteriaInterface $criteria
    )
    {
        $collection = $this->applicantCollectionFactory->create();
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
     * {@inheritdoc}
     */
    public function delete(
        ApplicantInterface $applicant
    )
    {
        try {
            $applicant->getResource()->delete($applicant);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Applicant: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($applicantId)
    {
        return $this->delete($this->getById($applicantId));
    }
}