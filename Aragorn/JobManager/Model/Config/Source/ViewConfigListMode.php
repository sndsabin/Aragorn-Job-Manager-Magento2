<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 12/22/17
 * Time: 10:47 AM
 */

namespace Aragorn\JobManager\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class ViewConfigListMode implements ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Yes')],
            ['value' => '0', 'label' => __('No')],
        ];
    }
}