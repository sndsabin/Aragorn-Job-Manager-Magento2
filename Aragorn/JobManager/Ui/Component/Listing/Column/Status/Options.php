<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/15/17
 * Time: 12:32 PM
 */

namespace Aragorn\JobManager\Ui\Component\Listing\Column\Status;


use Magento\Framework\Option\ArrayInterface;

class Options implements ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 1,
                'label' => __( 'Open' )
            ],
            [
                'value' => 0,
                'label' => __( 'Closed' )
            ]
        ];
    }
}