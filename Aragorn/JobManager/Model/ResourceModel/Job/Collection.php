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

namespace Aragorn\JobManager\Model\ResourceModel\Job;

use Aragorn\JobManager\Api\Data\JobInterface;
use Aragorn\JobManager\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $idFieldName = 'job_id';
    protected $previewFlag;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Aragorn\JobManager\Model\Job',
            'Aragorn\JobManager\Model\ResourceModel\Job'
        );

        $this->_map['fields']['store'] = 'store_table.store_id';
        $this->_map['fields']['job_id'] = 'main_table.job_id';

    }

    /**
     * Add filter by store
     *
     * @param $store
     * @param bool $withAdmin
     * @return mixed
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if (!$this->getFlag('store_filter_added')) {
            $this->performAddStoreFilter($store, $withAdmin);
        }
        return $this;
    }
    /**
     * Set first store flag
     *
     * @param bool $flag
     * @return $this
     */
    public function setFirstStoreFlag($flag = false)
    {
        $this->previewFlag = $flag;
        return $this;
    }
    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);
        $this->performAfterLoad('aragorn_jobmanager_job_store', $entityMetadata->getLinkField());
        $this->previewFlag = false;

        return parent::_afterLoad();
    }
    /**
     * Perform operations before rendering filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);
        $this->joinStoreRelationTable('aragorn_jobmanager_job_store', $entityMetadata->getLinkField());
    }
}
