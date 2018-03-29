<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/28/17
 * Time: 12:13 PM
 */

namespace Aragorn\JobManager\Ui\Component\Listing\Column\Position;

use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Aragorn\JobManager\Model\JobRepository;

class Title extends Column
{
    /**
     * @var Escaper
     */
    protected $escaper;
    /**
     * @var JobRepository
     */
    protected $jobRepository;

    /**
     * Title constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper $escaper
     * @param JobFactory $jobFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        JobRepository $jobRepository,
        array $components = [],
        array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->jobRepository = $jobRepository;
        $this->escaper = $escaper;
    }

    /**
     * Prepare Data Source
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $jobId = $item['job_id'];
                if (!is_null($jobId)) {
                    $job = $this->jobRepository->getById($jobId);

                    $item[$this->getData('name')] = $job->getPosition();
                } else {
                    $item[$this->getData('name')] = __('General Application');
                }

            }
        }

        return $dataSource;
    }
}