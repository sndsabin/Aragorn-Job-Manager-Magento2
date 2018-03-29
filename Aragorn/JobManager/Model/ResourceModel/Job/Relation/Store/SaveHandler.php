<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 1/2/18
 * Time: 4:27 PM
 */

namespace Aragorn\JobManager\Model\ResourceModel\Job\Relation\Store;

use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Aragorn\JobManager\Api\Data\JobInterface;
use Aragorn\JobManager\Model\ResourceModel\Job;
use Magento\Framework\EntityManager\MetadataPool;

class SaveHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;
    /**
     * @var Job
     */
    protected $resourceJob;

    public function __construct(
        MetadataPool $metadataPool,
        Job $resourceJob
    )
    {
        $this->metadataPool = $metadataPool;
        $this->resourceJob = $resourceJob;
    }

    /**
     * Perform action on relation/extension attribute
     *
     * @param object $entity
     * @param array $arguments
     * @return object|bool
     */
    public function execute($entity, $arguments = [])
    {
        $entityMetadata = $this->metadataPool->getMetadata(JobInterface::class);
        $linkField = $entityMetadata->getLinkField();

        $connection = $entityMetadata->getEntityConnection();

        $oldStores = $this->resourceJob->lookupStoreIds((int) $entity->getId());
        $newStores = (array) $entity->getStores();

        if (empty($newStores)) {
            $newStores = (array) $entity->getStoreId();
        }

        $table = $this->resourceJob->getTable('aragorn_jobmanager_job_store');

        $delete = array_diff($oldStores, $newStores);

        if ($delete) {
            $where = [
                $linkField . ' = ?' => (int) $entity->getData($linkField),
                'store_id IN (?)' => $delete,
            ];

            $connection->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);

        if ($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = [
                    $linkField => (int) $entity->getData($linkField),
                    'store_id' => (int) $storeId
                ];
            }

            $connection->insertMultiple($table, $data);
        }

        return $entity;
    }
}