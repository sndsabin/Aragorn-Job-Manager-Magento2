<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/16/17
 * Time: 4:44 PM
 */

namespace Aragorn\JobManager\Controller;

use \Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

abstract class Job extends Action\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;


    /**
     * Index constructor.
     * @param Action\Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}