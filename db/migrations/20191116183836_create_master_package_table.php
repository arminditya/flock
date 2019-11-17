<?php

use Phinx\Migration\AbstractMigration;

class CreateMasterPackageTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('mst_tour_package', ['id' => false, 'primary_key' => ['ID_TOUR_PACKAGE']])
            ->addColumn('ID_TOUR_PACKAGE','string')
            ->addColumn('DELETED', 'smallinteger', ['default' => 0])
            ->addColumn('JUDUL','string', ['limit' => 128, 'null' => true])
            ->addColumn('GAMBAR1','string', ['limit' => 256, 'null' => true])
            ->addColumn('GAMBAR2','string', ['limit' => 256, 'null' => true])
            ->addColumn('PRODUCT_DESCRIPTION','text', ['null' => true])
            ->addColumn('TOUR_ITINERARY','text', ['null' => true])
            ->addColumn('SERVICES','text', ['null' => true])
            ->addColumn('HARGA_PAKET', 'integer', ['default' => 0])
            ->addColumn('APPROVAL_STATUS','smallinteger',
                ['default' => 0, 'limit' => 1, 'comment' => '0=WAITING; 1=APPROVED;'])
            ->addColumn('APPROVED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('APPROVED_ON','datetime', ['null' => true])
            ->addColumn('ID_PROVINSI', 'biginteger', ['default' => 0])
            ->addColumn('ID_KOTA_KAB', 'biginteger', ['default' => 0])
            ->addColumn('ID_MATA_UANG', 'biginteger', ['default' => 0])
            ->addColumn('CREATED_BY','string', ['limit' => 64])
            ->addColumn('CREATED_ON','timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('UPDATED_BY','string', ['limit' => 64, 'null' => true])
            ->addColumn('UPDATED_ON','datetime', ['null' => true]);
        $table->create();
    }
}
