<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string', ['limit' => 64])
            ->addColumn('first_name', 'string', ['limit' => 128])
            ->addColumn('last_name', 'string', ['limit' => 128])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('modified_at', 'datetime', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }
}
