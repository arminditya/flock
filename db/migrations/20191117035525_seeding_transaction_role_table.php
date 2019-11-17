<?php

use Phinx\Migration\AbstractMigration;

class SeedingTransactionRoleTable extends AbstractMigration
{
    private $tableName = 'trx_user_role';

    public function up()
    {
        $single_row = [
            'ID_USER_ROLE' => '191102000000001',
            'USERNAME' => 'admin',
            'ID_ROLE' => 1,
            'CREATED_BY' => 'direct_inject'
        ];

        $table = $this->table($this->tableName);
        $table->insert($single_row);
        $table->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM '.$this->tableName);
    }
}
