<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'supplier_id' => '1',
                'supplier_kode, 10' => 'A001',
                'supplier_nama' => 'Supplier Makanan',
                'supplier_alamat' => 'Jalan Raya No. 1, Jakarta',

            ],
            [
                'supplier_id' => '2',
                'supplier_kode, 10' => 'A002',
                'supplier_nama' => 'Supplier Minuman',
                'supplier_alamat' => 'Jalan Merdeka No. 2, Bandung',

            ],
            [
                'supplier_id' => '3',
                'supplier_kode, 10' => 'A004',
                'supplier_nama' => 'Supplier Frozen Food',
                'supplier_alamat' => 'Jalan Sudirman No. 3, Surabaya',
 
            ],

        ];

        DB::table('m_supplier')->insert($data);
    }
}
