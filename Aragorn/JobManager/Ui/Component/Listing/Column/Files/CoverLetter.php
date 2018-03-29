<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/28/17
 * Time: 1:14 PM
 */

namespace  Aragorn\JobManager\Ui\Component\Listing\Column\Files;

use Magento\Framework\UrlInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;


class CoverLetter extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlInterface;

    /**
     * CoverLetter constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     * @param UrlInterface $urlInterface
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        array $components = [],
        array $data = [],
        UrlInterface $urlInterface
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->escaper = $escaper;
        $this->urlInterface = $urlInterface;
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
                $baseURL = str_replace('index.php/', '', $this->urlInterface->getBaseUrl());

                $item[$this->getData('name')] = '<a href="'.rtrim($baseURL, '/')  . '/pub/media/jobmanager/' . $item['cover_letter'].'" target="_blank">Letter</a>';

            }
        }

        return $dataSource;
    }

}