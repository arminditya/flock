<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionPackageTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('trx_tour_harga', ['id' => false, 'primary_key' => ['ID_TOUR_HARGA']])
            ->addColumn('ID_TOUR_HARGA','string')
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('HARGA_PAKET', 'integer', ['default' => 0])
            ->addColumn('PPN', 'float', ['default' => 0])
            ->addColumn('BIAYA_SISANTUY', 'float', ['default' => 0])
            ->addColumn('ID_TOUR_PACKAGE','string')
            ->addColumn('ID_MATA_UANG', 'biginteger', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
