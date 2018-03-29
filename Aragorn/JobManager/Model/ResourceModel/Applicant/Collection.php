<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 1:08 PM
 */
namespace Aragorn\JobManager\Model\ResourceModel\Applicant;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Aragorn\JobManager\Model\Applicant',
            'Aragorn\JobManager\Model\ResourceModel\Applicant'
        );
    }
}