<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterFeeTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_fee', ['id' => 'ID_FEE'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('JENIS_FEE','string', ['limit' => 64])
            ->addColumn('NAMA_FEE','string', ['limit' => 128])
            ->addColumn('PERSENTASE', 'float', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
