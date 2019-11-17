<?php

use Phinx\Migration\AbstractMigration;

class SeedingMasterMenuTable extends AbstractMigration
{
    private $tableName = 'mst_menu';

    public function up()
    {
        $rows = [
            [
                'NAMA_MENU' => 'Atur User',
                'ICON' => 'fa fa-user-plus',
                'URL' => 'SisantuyAdmin/AturUser/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Manage Role',
                'ICON' => 'fa fa-cog',
                'URL' => 'SisantuyAdmin/AturRole/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Manage Menu',
                'ICON' => 'fa fa-cog',
                'URL' => 'SisantuyAdmin/AturMenu/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Approval Tour Package',
                'ICON' => 'fa fa-check-square-o',
                'URL' => 'SisantuyAdmin/ApprovalTourPackage/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Manage Tour Package',
                'ICON' => 'fa fa-tripadvisor',
                'URL' => 'SisantuyGuide/AturTourPackage/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Accommodation',
                'ICON' => 'fa fa-hotel',
                'URL' => 'SisantuyGuide/AturAkomodasi/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Transportation',
                'ICON' => 'fa fa-plane',
                'URL' => 'SisantuyGuide/AturTransportasi/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Souvenirs',
                'ICON' => 'fa fa-shopping-cart',
                'URL' => 'SisantuyGuide/AturOlehOleh/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Manage Orders',
                'ICON' => 'fa fa-money',
                'URL' => 'SisantuyGuide/AturPesanan/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Profile Setting',
                'ICON' => 'fa fa-cogs',
                'URL' => 'SisantuyAll/AturProfilPribadi/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Atur Mata Uang',
                'ICON' => 'fa fa-money',
                'URL' => 'SisantuyAdmin/AturMataUang/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Atur Role - Menu',
                'ICON' => 'fa fa fa-cog',
                'URL' => 'SisantuyAdmin/AturRoleMenu',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Atur Provinsi',
                'ICON' => 'fa fa-map-o',
                'URL' => 'SisantuyAdmin/AturProvinsi/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Atur Kota-Kabupaten',
                'ICON' => 'fa fa-map-o',
                'URL' => 'SisantuyAdmin/AturKotaKab/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Manage Fee',
                'ICON' => 'fa fa-balance-scale',
                'URL' => 'SisantuyAdmin/AturFee/index',
                'CREATED_BY' => 'admin'
            ],
            [
                'NAMA_MENU' => 'Atur Discount',
                'ICON' => 'fa fa-cut',
                'URL' => 'SisantuyAdmin/AturDisc/index',
                'CREATED_BY' => 'admin'
            ]
        ];

        $this->table($this->tableName)->insert($rows)->save();
    }

    public function down()
    {
        $this->execute('DELETE FROM '.$this->tableName);
    }
}
