<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 1/2/18
 * Time: 4:38 PM
 */

namespace Aragorn\JobManager\Model\ResourceModel\Job\Relation\Store;

use Aragorn\JobManager\Model\ResourceModel\Job;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

class ReadHandler implements ExtensionInterface
{
    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @var Job
     */
    protected $resourceJob;

    /**
     * ReadHandler constructor.
     * @param MetadataPool $metadataPool
     * @param Job $resourceJob
     */
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
        if ($entity->getId()) {
            $stores = $this->resourceJob->lookupStoreIds((int) $entity->getId());
            $entity->setData('store_id', $stores);
            $entity->setData('store', $stores);
        }

        return $entity;
    }
}