<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterProvinceTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_provinsi', ['id' => 'ID_PROVINSI'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('NAMA_PROVINSI','string', ['limit' => 256])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
