<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionLoginTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_log_login', ['id' => false, 'primary_key' => ['ID_LOG_LOGIN']])
            ->addColumn('ID_LOG_LOGIN','string')
            ->addColumn('USERNAME','string', ['limit' => 64])
            ->addColumn('EMAIL','string', ['limit' => 256, 'null' => true])
            ->addColumn('IP_LOGIN','string', ['limit' => 64])
            ->addColumn('DATETIME_LOGIN','timestamp', ['default' => 'CURRENT_TIMESTAMP']);
        $table->create();
    }
}
