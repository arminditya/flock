<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterCurrencyTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_mata_uang', ['id' => 'ID_MATA_UANG'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('NAMA_MATA_UANG','string', ['limit' => 32])
            ->addColumn('SINGKATAN_MATA_UANG','string', ['limit' => 8])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
