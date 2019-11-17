<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterProvinceTable extends AbstractMigration
{
    private $tableName = 'mst_provinsi';

    public function up()
    {
        $rows = [
            [
                'NAMA_PROVINSI' => 'DKI Jakarta',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Banten',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Jawa Barat',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Jawa Tengah',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Jawa Timur',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'DI Yogyakarta',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Bali',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Nusa Tenggara Barat',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_PROVINSI' => 'Nusa Tenggara Timur',
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
