<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 1/3/18
 * Time: 11:31 AM
 */

namespace Aragorn\JobManager\Model;

use Aragorn\JobManager\Model\ResourceModel\Job\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var ResourceModel\Job\Collection
     */
    protected $collection;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var array
     */
    protected $loadedData;

    /**
    * DataProvider constructor.
    * @param string $name
    * @param string $primaryFieldName
    * @param string $requestFieldName
    * @param array $meta
    * @param array $data
    * @param CollectionFactory $pageCollectionFactory
    * @param DataPersistorInterface $dataPersistor
    */
    public function __construct(
    $name, $primaryFieldName, $requestFieldName, array $meta = [], array $data = [], CollectionFactory $pageCollectionFactory, DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->meta = $this->prepareMeta($this->meta);
    }
    
    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Aragorn\JobManager\Model\Job $job */
        foreach ($items as $job) {
            $this->loadedData[$job->getId()] = $job->getData();
        }

        $data = $this->dataPersistor->get('aragorn_jobmanager_job');
        if (!empty($data)) {
            $block = $this->collection->getNewEmptyItem();
            $block->setData($data);
            $this->loadedData[$job->getId()] = $job->getData();
            $this->dataPersistor->clear('aragorn_jobmanager_job');
        }

        return $this->loadedData;
    }
}