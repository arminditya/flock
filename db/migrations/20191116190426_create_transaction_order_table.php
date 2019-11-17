<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionOrderTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_order', ['id' => false, 'primary_key' => ['ID_ORDER']])
            ->addColumn('ID_ORDER','string')
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('HARGA_AWAL', 'integer', ['default' => 0])
            ->addColumn('POTONGAN', 'integer', ['default' => 0])
            ->addColumn('PAJAK', 'integer', ['default' => 0])
            ->addColumn('HARGA_DITAGIHKAN', 'integer', ['default' => 0])
            ->addColumn('STATUS_ORDER','smallinteger',
                ['default' => 1, 'limit' => 1, 'comment' => '1=ORDER; 2=ACCEPTED; 3=PUBLISHED;'])
            ->addColumn('TGL_ORDER','date', ['null' => true])
            ->addColumn('WKT_ORDER','datetime', ['null' => true])
            ->addColumn('WKT_PEMBAYARAN_DITERIMA','datetime', ['null' => true])
            ->addColumn('WKT_TICKET_ISSUED','datetime', ['null' => true])
            ->addColumn('ID_TOUR_PACKAGE', 'string')
            ->addColumn('ID_MATA_UANG', 'biginteger')
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
