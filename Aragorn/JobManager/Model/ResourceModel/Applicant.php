<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 1:04 PM
 */

namespace Aragorn\JobManager\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Applicant extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('aragorn_jobmanager_applicant', 'applicant_id');
    }
}