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

namespace Aragorn\JobManager\Model\ResourceModel;



use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

// For multiscope store view
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\EntityManager\MetadataPool;
use Aragorn\JobManager\Api\Data\JobInterface;

use Magento\Framework\DB\Select;

class Job extends AbstractDb
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var DateTime
     */
    protected $dateTime;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var MetadataPool
     */
    protected $metadataPool;


    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        DateTime $dateTime,
        EntityManager $entityManager,
        MetadataPool $metadataPool,
        $connectionName = null
    )
    {
        parent::__construct($context, $connectionName);
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
        $this->entityManager = $entityManager;
        $this->metadataPool = $metadataPool;

    }

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('aragorn_jobmanager_job', 'job_id');
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection()
    {
        return $this->metadataPool->getMetadata(JobInterface::class)->getEntityConnection();
    }

    /**
     * @param AbstractModel $object
     * @param $value
     * @param null $field
     * @return bool|int|string
     */
    private function getJobId(AbstractModel $object, $value, $field = null)
    {
        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);

        if (!is_numeric($value) && $field === null) {
            $field = 'job_id';
        } elseif (!$field) {
            $field = $entityMetadata->getIdentifierField();
        }

        $jobId = $value;
        if ($field != $entityMetadata->getIdentifierField() || $object->getStoreId()) {
            $select = $this->_getLoadSelect($field, $value, $object);
            $select->reset(Select::COLUMNS)
                ->columns($this->getMainTable() . '.' . $entityMetadata->getIdentifierField())
                ->limit(1);
            $result = $this->getConnection()->fetchCol($select);
            $jobId = count($result) ? $result[0] : false;
        }
        return $jobId;
    }

    /**
     * Load an object
     * @param AbstractModel $object
     * @param mixed $value
     * @param null $field
     * @return $this
     */
    public function load(AbstractModel $object, $value, $field = null)
    {
        $jobId = $this->getJobId($object, $value, $field);
        if ($jobId) {
            $this->entityManager->load($object, $jobId);
        }
        return $this;
    }

    /**
     * Retrieve Select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param AbstractModel $object
     * @return Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = parent::_getLoadSelect($field, $value, $object);

        if ($object->getStoreId()) {
            $storeIds = [
                Store::DEFAULT_STORE_ID,
                (int) $object->getStoreId(),
            ];
            $select->join(
                ['aragorn_jobmanager_job_store' => $this->getTable('aragorn_jobmanager_job_store')],
                $this->getMainTable() . '.' . $linkField . ' = aragorn_jobmanager_job_store.' . $linkField,
                []
            )
                ->where('is_active = ?', 1)
                ->where('aragorn_jobmanager_job_store.store_id IN (?)', $storeIds)
                ->order('aragorn_jobmanager_job_store.store_id DESC')
                ->limit(1);
        }

        return $select;
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param $id
     * @return array
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();

        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $select = $connection->select()
            ->from(['aragorn_jobmanager_job_store' => $this->getTable('aragorn_jobmanager_job_store')], 'store_id')
            ->join(
                ['aragorn_jobmanager_job' => $this->getMainTable()],
                'aragorn_jobmanager_job_store.' . $linkField . ' = aragorn_jobmanager_job.' . $linkField,
                []
            )
            ->where('aragorn_jobmanager_job.' . $entityMetadata->getIdentifierField() . ' = :job_id');

        return $connection->fetchCol($select, ['job_id' => (int)$id]);
    }

    /**
     * @param AbstractModel $object
     * @return $this
     */
    public function save(AbstractModel $object)
    {
        $this->entityManager->save($object);
        return $this;
    }

    /**
     * @param AbstractModel $object
     * @return $this
     */
    public function delete(AbstractModel $object)
    {
        $this->entityManager->delete($object);
        return $this;
    }
}
