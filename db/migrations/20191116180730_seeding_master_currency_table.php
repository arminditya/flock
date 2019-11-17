<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterCurrencyTable extends AbstractMigration
{
    private $tableName = 'mst_mata_uang';

    public function up()
    {
        $rows = [
            [
                'NAMA_MATA_UANG' => 'Rupiah',
                'SINGKATAN_MATA_UANG' => 'IDR',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MATA_UANG' => 'United States Dollar',
                'SINGKATAN_MATA_UANG' => 'USD',
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
