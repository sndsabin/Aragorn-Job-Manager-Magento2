<?php
/**
 * Created by PhpStorm.
 * User: sndsabin
 * Date: 11/23/17
 * Time: 1:23 PM
 */

namespace Aragorn\JobManager\Model;


use Aragorn\JobManager\Api\Data\Applicant\ApplicantInterface;
use Magento\Framework\Model\AbstractModel;

class Applicant extends AbstractModel implements ApplicantInterface
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Aragorn\JobManager\Model\ResourceModel\Applicant');
    }
    /**
     * Get applicant_id
     * @return string
     */
    public function getApplicantId()
    {
        return $this->getData(self::APPLICANT_ID);
    }

    /**
     * Set applicant_id
     * @param string $applicantId
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setApplicantId($applicantId)
    {
        return $this->setData(self::APPLICANT_ID, $applicantId);
    }

    /**
     * Get job_id
     * @return string
     */
    public function getJobId()
    {
        return $this->getData(self::JOB_ID);
    }

    /**
     * Set job_id
     * @param string $job_id
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setJobId($job_id)
    {
        return $this->setData(self::JOB_ID, $job_id);
    }

    /**
     * Get email
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * Set email
     * @param string $email
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Get firstname
     * @return string
     */
    public function getFirstname()
    {
        return $this->getData(self::FIRSTNAME);
    }

    /**
     * Set firstname
     * @param string $firstname
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * Get lastname
     * @return string
     */
    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    /**
     * Set lastname
     * @param string $lastname
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * Get phone
     * @return string
     */
    public function getPhone()
    {
        return $this->getData(self::PHONE);
    }

    /**
     * Set phone
     * @param string $phone
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setPhone($phone)
    {
        return $this->setData(self::PHONE, $phone);
    }

    /**
     * Get address
     * @return string
     */
    public function getAddress()
    {
        return $this->getData(self::ADDRESS);
    }

    /**
     * Set address
     * @param string $address
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setAddress($address)
    {
        return $this->setData(self::ADDRESS, $address);
    }

    /**
     * Get zip_code
     * @return string
     */
    public function getZipCode()
    {
        return $this->getData(self::ZIP_CODE);
    }

    /**
     * Set zip_code
     * @param string $zip_code
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setZipCode($zip_code)
    {
        return $this->setData(self::ZIP_CODE, $zip_code);
    }

    /**
     * Get city
     * @return string
     */
    public function getCity()
    {
        return $this->getCity(self::CITY);
    }

    /**
     * Set city
     * @param string $zip_code
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setCity($city)
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * Get country
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * Set country_id
     * @param string $country
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * Get cv
     * @return string
     */
    public function getCv()
    {
        return $this->getData(self::CV);
    }

    /**
     * Set cv
     * @param string $cv
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setCv($cv)
    {
        return $this->setData(self::CV, $cv);
    }

    /**
     * Get cover_letter
     * @return string
     */
    public function getCoverLetter()
    {
        return $this->getData(self::COVER_LETTER);
    }

    /**
     * Set cover_letter
     * @param string $cover_letter
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setCoverLetter($cover_letter)
    {
        return $this->setData(self::COVER_LETTER, $cover_letter);
    }

    /**
     * Get created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $created_at
     * @return \Aragorn\JobManager\Api\Data\ApplicantInterface
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }
}