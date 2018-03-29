<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 12:00 PM
 */

namespace Aragorn\JobManager\Api;

use Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ApplicantRepositoryInterface
{
    /**
     * Save Applicant
     * @param \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface $applicant
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(ApplicantInterface $applicant);
    /**
     * Retrieve Applicant
     * @param string $applicantId
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($applicantId);

    /**
     * Retrieve Applicant matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * Delete Applicant
     * @param \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface $applicant
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(ApplicantInterface $applicant);

    /**
     * Delete Applicant by ID
     * @param string $applicantId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($applicantId);


}