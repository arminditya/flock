<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionPasswordTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_user_password', ['id' => 'ID_USER_PASSWORD'])
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('USERNAME','string', ['limit' => 64])
            ->addColumn('PSSWD','string', ['limit' => 32])
            ->addColumn('PSSWD_DEFAULT','string', ['limit' => 32])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
