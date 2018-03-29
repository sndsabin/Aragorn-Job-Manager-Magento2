<?php
/**
 * A Magento 2 module named Aragorn/JobManager
 * Copyright (C) 2017
 *
 * This file is part of Aragorn/JobManager.
 *
 * Aragorn/JobManager is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Aragorn\JobManager\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Jobs Table Schema
         */
        $table_aragorn_jobmanager_job = $setup->getConnection()
            ->newTable(
                $setup->getTable(
                    'aragorn_jobmanager_job'
                )
            );


        $table_aragorn_jobmanager_job->addColumn(
            'job_id',
            Table::TYPE_INTEGER,
            null,
            array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ),
            'Entity ID'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'position',
            Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'Job Position Title'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'location',
            Table::TYPE_TEXT,
            null,
            [],
            'location'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'education',
            Table::TYPE_TEXT,
            null,
            [],
            'Education'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'description',
            Table::TYPE_TEXT,
            null,
            [],
            'Job Description'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'deadline',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => False],
            'Job Deadline'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => False,
                'default' => Table::TIMESTAMP_INIT
            ],
            'Post Created At'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'updated_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'default' => Table::TIMESTAMP_INIT_UPDATE
            ],
            'Post Updated At'
        );


        $table_aragorn_jobmanager_job->addColumn(
            'status',
            Table::TYPE_BOOLEAN,
            null,
            [],
            'Job Status'
        );

        /**
         *Applicant Table Schema
         **/
        $table_aragorn_jobmanager_applicant = $setup->getConnection()
            ->newTable(
                $setup->getTable(
                    'aragorn_jobmanager_applicant'
                )
            );


        $table_aragorn_jobmanager_applicant->addColumn(
            'applicant_id',
            Table::TYPE_INTEGER,
            null,
            array(
                'identity' => true,
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
                ),
            'Entity ID'
        );

        $table_aragorn_jobmanager_applicant->addColumn(
            'job_id',
            Table::TYPE_INTEGER,
            null,
            array(
                'nullable' => true,
                'unsigned' => true,
            ),
            'Job Applied For'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant Email'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'firstname',
            Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'Applicant Firstname'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'lastname',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant Lastname'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'phone',
            Table::TYPE_TEXT,
            255,
            ['nullable' => False],
            'phone'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'address',
            Table::TYPE_TEXT,
            null,
            [],
            'Applicant Address'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'zip_code',
            Table::TYPE_TEXT,
            null,
            [],
            'Applicant Zip Code'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant City'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'country',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant Country'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'cv',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant CV Document'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'cover_letter',
            Table::TYPE_TEXT,
            255,
            [],
            'Applicant Cover Letter'
        );


        $table_aragorn_jobmanager_applicant->addColumn(
            'created_at',
            Table::TYPE_TIMESTAMP,
            null,
            [
                'nullable' => False,
                'default' => Table::TIMESTAMP_INIT
            ],
            'Created At Timestamp'
        );


        $table_aragorn_jobmanager_applicant->addForeignKey(
            $installer->getFkName('aragorn_jobmanager_applicant', 'job_id', '	aragorn_jobmanager_job', 'job_id'),
            'job_id',
            $installer->getTable('aragorn_jobmanager_job'),
            'job_id',
            Table::ACTION_SET_NULL
        );

        /**
         * JobManager_Store Pivot Table Schema
         */
        $table_aragorn_Jobmanger_job_store = $setup->getConnection()
            ->newTable(
                $setup->getTable(
                    'aragorn_jobmanager_job_store'
                )
            );

        $table_aragorn_Jobmanger_job_store->addColumn(
            'job_id',
            Table::TYPE_INTEGER,
            null,
            array(
                'nullable' => false,
                'primary' => true,
                'unsigned' => true
                ),
            'Job Id'
        );

        $table_aragorn_Jobmanger_job_store->addColumn(
            'store_id',
            Table::TYPE_SMALLINT,
            null,
            array(
                'nullable' => false,
                'primary' => true,
                'unsigned' => true,
            ),
            'Store Id'
        );

        $table_aragorn_Jobmanger_job_store->addIndex(
            $installer->getIdxName('aragorn_jobmanager_job_store', ['store_id']),
            ['store_id']
        );


        $table_aragorn_Jobmanger_job_store->addForeignKey(
            $installer->getFkName('aragorn_jobmanager_job_store', 'job_id', 'aragorn_jobmanager_job', 'job_id'),
            'job_id',
            $installer->getTable('aragorn_jobmanager_job'),
            'job_id',
            Table::ACTION_CASCADE
        );

        $table_aragorn_Jobmanger_job_store->addForeignKey(
            $installer->getFkName('aragorn_jobmanager_job_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $installer->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        );



        $table_aragorn_Jobmanger_job_store->setComment('Jobs To Store Linkage Table');

        $setup->getConnection()->createTable($table_aragorn_jobmanager_job);
        $setup->getConnection()->createTable($table_aragorn_jobmanager_applicant);
        $setup->getConnection()->createTable($table_aragorn_Jobmanger_job_store);

        $setup->endSetup();
    }
}
