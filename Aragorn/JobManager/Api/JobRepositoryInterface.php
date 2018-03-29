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

namespace Aragorn\JobManager\Api;

use Aragorn\JobManager\Api\Data\JobInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface JobRepositoryInterface
{


    /**
     * Save Job
     * @param JobInterface $job
     * @return JobInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        JobInterface $job
    );

    /**
     * Retrieve Job
     * @param string $jobId
     * @return JobInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($jobId);

    /**
     * Retrieve Job matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Aragorn\JobManager\Api\Data\JobSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Job
     * @param JobInterface $job
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        JobInterface $job
    );

    /**
     * Delete Job by ID
     * @param string $jobId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($jobId);
}
