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

use Carbon\Carbon;
use Aragorn\JobManager\Api\Data\JobInterface;
use Magento\Framework\Model\AbstractModel;

class Job extends AbstractModel implements JobInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Aragorn\JobManager\Model\ResourceModel\Job');
    }

    /**
     * Get job_id
     * @return string
     */
    public function getJobId()
    {
        return $this->getData(self::JOB_ID);
    }

    /**
     * Set job_id
     * @param string $jobId
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setJobId($jobId)
    {
        return $this->setData(self::JOB_ID, $jobId);
    }

    /**
     * Get position
     * @return string
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Set position
     * @param string $position
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get location
     * @return string
     */
    public function getLocation()
    {
        return $this->getData(self::LOCATION);
    }

    /**
     * Set location
     * @param string $location
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setLocation($location)
    {
        return $this->setData(self::LOCATION, $location);
    }

    /**
     * Get education
     * @return string
     */
    public function getEducation()
    {
        return $this->getData(self::EDUCATION);
    }

    /**
     * Set education
     * @param string $education
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setEducation($education)
    {
        return $this->setData(self::EDUCATION, $education);
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get Deadline
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->getData(self::DEADLINE);
    }

    /**
     * Get deadline in Human Readable format
     * @return string
     */
    public function getDeadlineDiffForHumans()
    {
          return Carbon::parse($this->getData(self::DEADLINE))->diffForHumans();
    }

    /**
     * Set deadline
     * @param string $deadline
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setDeadline($deadline)
    {
        return $this->setData(self::DEADLINE, $deadline);
    }

    /**
     * Get created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return Carbon::parse($this->getData(self::CREATED_AT))->toDateString();
    }

    /**
     * Set created_at
     * @param string $created_at
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * Get updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated_at
     * @param string $updated_at
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setUpdatedAt($updated_at)
    {
        return $this->setData(self::UPDATED_AT, $updated_at);
    }

    /**
     * Get status
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS) ? __( 'Open' ) :  __( 'Closed' );
    }

    /**
     * Set status
     * @param string $status
     * @return \Aragorn\JobManager\Api\Data\JobInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Receive page store ids
     *
     * @return int[]
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') : (array)$this->getData('store_id');
    }
}
