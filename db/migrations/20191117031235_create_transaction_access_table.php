<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionAccessTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_role_menu', ['id' => 'ID_ROLE_MENU'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('ID_ROLE', 'biginteger', ['default' => 0])
            ->addColumn('ID_MENU', 'biginteger', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
