<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 12:08 PM
 */

namespace Aragorn\JobManager\Api\Data\Applicant;


interface ApplicantInterface
{

    const EMAIL = 'email';
    const CITY = 'city';
    const COUNTRY = 'country';
    const JOB_ID = 'job_id';
    const ADDRESS = 'address';
    const ZIP_CODE = 'zip_code';
    const APPLICANT_ID = 'applicant_id';
    const COVER_LETTER = 'cover_letter';
    const CREATED_AT = 'created_at';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const PHONE = 'phone';
    const CV = 'cv';


    /**
     * Get applicant_id
     * @return string|null
     */
    public function getApplicantId();

    /**
     * Set applicant_id
     * @param string $applicant_id
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setApplicantId($applicantId);

    /**
     * Get email
     * @return string|null
     */
    public function getEmail();

    /**
     * Set email
     * @param string $email
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setEmail($email);

    /**
     * Get firstname
     * @return string|null
     */
    public function getFirstname();

    /**
     * Set firstname
     * @param string $firstname
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setFirstname($firstname);

    /**
     * Get lastname
     * @return string|null
     */
    public function getLastname();

    /**
     * Set lastname
     * @param string $lastname
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setLastname($lastname);

    /**
     * Get phone
     * @return string|null
     */
    public function getPhone();

    /**
     * Set phone
     * @param string $phone
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setPhone($phone);

    /**
     * Get address
     * @return string|null
     */
    public function getAddress();

    /**
     * Set address
     * @param string $address
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setAddress($address);

    /**
     * Get zip_code
     * @return string|null
     */
    public function getZipCode();

    /**
     * Set zip_code
     * @param string $zip_code
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setZipCode($zip_code);

    /**
     * Get City
     * @return string|null
     */
    public function getCity();

    /**
     * Set City
     * @param string $City
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setCity($City);

    /**
     * Get country_id
     * @return string|null
     */
    public function getCountry();

    /**
     * Set country
     * @param string $countryd
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setCountry($country);

    /**
     * Get cv
     * @return string|null
     */
    public function getCv();

    /**
     * Set cv
     * @param string $cv
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setCv($cv);

    /**
     * Get cover_letter
     * @return string|null
     */
    public function getCoverLetter();

    /**
     * Set cover_letter
     * @param string $cover_letter
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setCoverLetter($cover_letter);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return \Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface
     */
    public function setCreatedAt($created_at);
}