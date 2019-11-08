<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('user_id', 'integer')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
