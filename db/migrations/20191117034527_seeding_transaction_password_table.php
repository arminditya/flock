<?php

use Phinx\Migration\AbstractMigration;

class SeedingTransactionPasswordTable extends AbstractMigration
{
    private $tableName = 'trx_user_password';

    public function up()
    {
        $single_row = [
            'USERNAME' => 'admin',
            'PSSWD' => '21232f297a57a5a743894a0e4a801fc3',
            'PSSWD_DEFAULT' => '81dc9bdb52d04dc20036dbd8313ed055',
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
