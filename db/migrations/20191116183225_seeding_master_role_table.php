<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterRoleTable extends AbstractMigration
{
    private $tableName = 'mst_role';

    public function up()
    {
        $rows = [
            [
                'NAMA_ROLE' => 'Admin',
                'CREATED_BY' => 'direct_inject'
            ],
            [
                'NAMA_ROLE' => 'Local Guide',
                'CREATED_BY' => 'direct_inject'
            ],
            [
                'NAMA_ROLE' => 'Traveller',
                'CREATED_BY' => 'direct_inject'
            ]
        ];

        $this->table($this->tableName)->insert($rows)->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM '.$this->tableName);
    }
}
