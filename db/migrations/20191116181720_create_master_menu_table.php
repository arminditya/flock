<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterMenuTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_menu', ['id' => 'ID_MENU'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('NAMA_MENU','string', ['limit' => 32])
            ->addColumn('ICON','string', ['limit' => 256, 'null' => true])
            ->addColumn('URL','string', ['limit' => 256])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
