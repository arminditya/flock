<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterDistrictTable extends AbstractMigration
{
    private $tableName = 'mst_kota_kab';

    public function up()
    {
        $rows = [
            [
                'ID_PROVINSI' => 1,
                'NAMA_KOTA_KAB' => 'Jakarta Utara',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 1,
                'NAMA_KOTA_KAB' => 'Jakarta Pusat',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 1,
                'NAMA_KOTA_KAB' => 'Jakarta Barat',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 1,
                'NAMA_KOTA_KAB' => 'Jakarta Timur',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 3,
                'NAMA_KOTA_KAB' => 'Kab. Bogor',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 3,
                'NAMA_KOTA_KAB' => 'Kota Bandung',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 3,
                'NAMA_KOTA_KAB' => 'Kab. Garut',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 7,
                'NAMA_KOTA_KAB' => 'Kab. Ubud',
                'CREATED_BY' => 'admin'
            ],
            [
                'ID_PROVINSI' => 7,
                'NAMA_KOTA_KAB' => 'Kota Denpasar',
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
