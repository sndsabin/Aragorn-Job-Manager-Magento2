# Aragorn Job Manager - Magneto 2 Extension

## Introduction

> **Aragorn Job Manager** is Magento 2 jobs and recruitment extension that empowers to you to create a seperate job section on your magento store.  It  allows you to add jobs and interact directly with job seekers.

## Features

* Create Multiple Jobs With Eligibility Criteria
* Manage Candidate Applications, CVs and Cover Letter
*  Jobs Email Notifications
* Configurable Email and View Settings via Stores > Configuration > Job Manager
* Linkedin Apply Button
* General Application Supported

## Installation

### Step 1
* ``` git clone git@github.com:sndsabin/Aragorn-Job-Manager-Magento2.git```
*  **copy the Aragorn Folder and place it on your app/code directory**

### Step 2
**Aragorn JobManager** uses *Carbon* library.  **cd** into your **magento root directory** and install the *carbon* package via composer
```php
composer require nesbot/carbon
```

### Step 3
 **cd** into your **magento root directory** and
```php
php bin/magento module:enable Aragorn_JobManager
php bin/magento setup:upgrade
```
### Step 4
To Configure the Email. Go to 
**Stores > Configuration > Job Manager > Email Setting**

![Email Setting](/Screenshots/email-setting-configuration.png "Email Configuration ")
### Step 5 (Optional)
If you want to enable **linkedin apply** button on Job Apply Page. Go to 
* Stores > Configuration > Job Manager > Linkedin API
* Enter your Linkedin Client API key and save
![Linkedin API Setting](/Screenshots/linkedin-API-configuration.png "Linkedin API Configuration")

##### To obtain Linkedin API, go to [Linkedin](developer.linkedin.com) and create New Application.

#### Email Notifications and other configurations can be changed via *Stores > Configuration > Job Manager* 

![View Setting](/Screenshots/view-setting-configuration.png "View Setting Configuration")

### Step 6 (Optional)
#### For Terms and conditions, create a Terms and Condition page via Content > Page and use *terms* as route

## Post Jobs (Admin Section)
* Go to Aragorn > Job Manager > Add New Job
* Fill the information 
* Save

![Aragorn Job Manager Admin Menu](/Screenshots/jobmanager-admin-menu.png "Aragorn Job Manager Admin Menu")

![Job list Admin](/Screenshots/job-list-admin.png "Job List Admin")

![Post New Job Admin](/Screenshots/post-new-job-admin.png "New Job Form Admin")



## Job will be listed on *job* route. Ex: www.yourdomain.com/job
![Job List Page](/Screenshots/job-list-frontend.png "Job Listing Frontend")

![Job Detail Page](/Screenshots/job-detail-page-frontend.png "Job Detail Page Frontend")

![Job Apply Page](/Screenshots/job-apply-frontend.png "Job Apply Frontend")

![General Job Apply Page](/Screenshots/general-application-frontend.png "General Application Frontend")

## Job Applicants (Admin Section)
* Go to Aragorn > Job Applicants 
* All the Applicants are listed there.

![Job Applicants Admin](/Screenshots/jobapplicants-admin.png "Job Applicants Admin")
