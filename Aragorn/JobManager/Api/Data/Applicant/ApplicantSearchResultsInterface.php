<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 12:54 PM
 */

namespace Aragorn\JobManager\Api\Data\Applicant;


use Magento\Framework\Api\SearchResultsInterface;

interface ApplicantSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get Applicant list.
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface[]
     */
    public function getItems();

    /**
     * Set email list.
     * @param \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}