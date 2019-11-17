<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterUserTable extends AbstractMigration
{
    private $tableName = 'mst_user';

    public function up()
    {
        $single_row = [
            'USERNAME' => 'admin',
            'NAMA'  => 'Administrator',
            'JENIS_KELAMIN' => 'L',
            'NO_HP' => '082323116567',
            'EMAIL' => 'anggitsuryagumilang@gmail.com',
            'TGL_LAHIR' => '1995-09-18',
            'ID_ROLE' => 1,
            'CREATED_BY' => 'direct_inject'
        ];

        $table = $this->table($this->tableName);
        $table->insert($single_row);
        $table->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM '.$this->tableName);
    }
}
