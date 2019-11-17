<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterUserTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_user', ['id' => 'ID'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('USERNAME','string', ['limit' => 64])
            ->addColumn('NAMA','string', ['limit' => 256])
            ->addColumn('JENIS_KELAMIN','string', ['limit' => 1, 'comment' => 'P=WOMAN; L=MAN'])
            ->addColumn('NO_HP','string', ['limit' => 16, 'null' => true])
            ->addColumn('EMAIL','string', ['limit' => 256])
            ->addColumn('TGL_LAHIR','date', ['null' => true])
            ->addColumn('ID_ROLE', 'biginteger')
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true])
            ->addIndex(['USERNAME', 'EMAIL'], ['unique' => true]);
        $table->create();
    }
}
