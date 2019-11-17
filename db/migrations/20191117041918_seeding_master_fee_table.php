<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterFeeTable extends AbstractMigration
{
    private $tableName = 'mst_fee';

    public function up()
    {
        $rows = [
            [
                'JENIS_FEE' => 'PPN',
                'NAMA_FEE' => 'Pajak Pertambahan Nilai',
                'PERSENTASE' => 10,
                'CREATED_BY' => 'admin'
            ],
            [
                'JENIS_FEE' => 'FADM',
                'NAMA_FEE' => 'Admin Fee',
                'PERSENTASE' => 2,
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
