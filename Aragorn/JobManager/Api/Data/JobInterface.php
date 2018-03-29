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

namespace Aragorn\JobManager\Api\Data;

interface JobInterface
{

    const LOCATION = 'location';
    const DESCRIPTION = 'description';
    const DEADLINE = 'deadline';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const EDUCATION = 'education';
    const POSITION = 'position';
    const JOB_ID = 'job_id';
    const UPDATED_AT = 'updated_at';


    /**
     * Get job_id
     * @return string|null
     */
    public function getJobId();

    /**
     * Set job_id
     * @param string $job_id
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setJobId($jobId);

    /**
     * Get position
     * @return string|null
     */
    public function getPosition();

    /**
     * Set position
     * @param string $position
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setPosition($position);

    /**
     * Get location
     * @return string|null
     */
    public function getLocation();

    /**
     * Set location
     * @param string $location
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setLocation($location);

    /**
     * Get education
     * @return string|null
     */
    public function getEducation();

    /**
     * Set education
     * @param string $education
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setEducation($education);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setDescription($description);

    /**
     * Get deadline
     * @return string|null
     */
    public function getDeadline();

    /**
     * Set deadline
     * @param string $deadline
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setDeadline($deadline);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setCreatedAt($created_at);

    /**
     * Get updated_at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updated_at
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setUpdatedAt($updated_at);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setStatus($status);
}
