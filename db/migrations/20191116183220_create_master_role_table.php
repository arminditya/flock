<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterRoleTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_role', ['id' => 'ID_ROLE'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('NAMA_ROLE','string', ['limit' => 128])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
