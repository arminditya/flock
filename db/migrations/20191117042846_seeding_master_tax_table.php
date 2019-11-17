<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterTaxTable extends AbstractMigration
{
    private $tableName = 'mst_pajak';

    public function up()
    {
        $single_row = [
            'JENIS_PAJAK' => 'PPN',
            'NAMA_PAJAK' => 'Pajak Pertambahan Nilai',
            'PERSENTASE' => 10,
            'CREATED_BY' => 'admin'
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
