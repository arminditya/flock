<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionRoleTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_user_role', ['id' => false, 'primary_key' => ['ID_USER_ROLE']])
            ->addColumn('ID_USER_ROLE','string')
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('USERNAME','string', ['limit' => 64])
            ->addColumn('ID_ROLE', 'biginteger', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
