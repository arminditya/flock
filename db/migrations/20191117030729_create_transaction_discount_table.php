<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionDiscountTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_potongan_harga', ['id' => false, 'primary_key' => ['ID_POTONGAN_HARGA']])
            ->addColumn('ID_POTONGAN_HARGA','string')
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('PERSEN_POTONGAN', 'integer', ['default' => 0])
            ->addColumn('ID_TOUR_PACKAGE', 'string')
            ->addColumn('STATUS','smallinteger',
                ['default' => 0, 'limit' => 1, 'comment' => '0=INACTIVE; 1=ACTIVE;'])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
