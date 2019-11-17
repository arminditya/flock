<?php

use Phinx\Migration\AbstractMigration;

class SeedingTransactionAccessTable extends AbstractMigration
{
    private $tableName = 'trx_role_menu';

    public function up()
    {
        $rows = [
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 1,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 2,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 3,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 4,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 5,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 6,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 7,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 8,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 9,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 10,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 10,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 17,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 16,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 18,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 19,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 20,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 1,
                'ID_MENU' => 21,
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_ROLE' => 2,
                'ID_MENU' => 22,
                'CREATED_BY' => 'admin'
            ]
        ];

        $this->table($this->tableName)->insert($rows)->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM '.$this->tableName);
    }
}
