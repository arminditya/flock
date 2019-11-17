<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterDistrictTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_kota_kab', ['id' => 'ID_KOTA_KAB'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('ID_PROVINSI', 'biginteger')
            ->addColumn('NAMA_KOTA_KAB','string', ['limit' => 256])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
