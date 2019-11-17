<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterTaxTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_pajak', ['id' => 'ID_PAJAK'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('JENIS_PAJAK','string', ['limit' => 64])
            ->addColumn('NAMA_PAJAK','string', ['limit' => 128])
            ->addColumn('PERSENTASE', 'float', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
