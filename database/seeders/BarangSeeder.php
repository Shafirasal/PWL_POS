<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Supplier 1: Indofood
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'CTO',
                'barang_nama' => 'Chitato',
                'harga_beli' => 4800,
                'harga_jual' => 5500,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 2,
                'barang_kode' => 'IDM',
                'barang_nama' => 'Indomilk',
                'harga_beli' => 5500,
                'harga_jual' => 6500,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 3,
                'barang_kode' => 'BFF',
                'barang_nama' => 'Beef Slice',
                'harga_beli' => 20000,
                'harga_jual' => 25000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 4,
                'barang_kode' => 'FRD',
                'barang_nama' => 'Frozen Durian',
                'harga_beli' => 15000,
                'harga_jual' => 18000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 5,
                'barang_kode' => 'DLS',
                'barang_nama' => 'Delfi Dark Choco',
                'harga_beli' => 10000,
                'harga_jual' => 12000,
            ],
            
            // Supplier 2: OTGroup
            [
                'barang_id' => 6,
                'kategori_id' => 1,
                'barang_kode' => 'TWT',
                'barang_nama' => 'Tango Wafer',
                'harga_beli' => 3500,
                'harga_jual' => 4500,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 2,
                'barang_kode' => 'BMK',
                'barang_nama' => 'Beng-Beng Drink',
                'harga_beli' => 5500,
                'harga_jual' => 6000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 3,
                'barang_kode' => 'FTS',
                'barang_nama' => 'Fish Stick',
                'harga_beli' => 17000,
                'harga_jual' => 22000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 4,
                'barang_kode' => 'APP',
                'barang_nama' => 'Apple Fuji',
                'harga_beli' => 5000,
                'harga_jual' => 6000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'CHS',
                'barang_nama' => 'Cheesecake Slice',
                'harga_beli' => 8000,
                'harga_jual' => 10000,
            ],
            
            // Supplier 3: Japfa Food
            [
                'barang_id' => 11,
                'kategori_id' => 1,
                'barang_kode' => 'PNG',
                'barang_nama' => 'Pineapple Snack',
                'harga_beli' => 4500,
                'harga_jual' => 5000,
            ],
            [
                'barang_id' => 12,
                'kategori_id' => 2,
                'barang_kode' => 'YMG',
                'barang_nama' => 'Yakult Mini',
                'harga_beli' => 3000,
                'harga_jual' => 3500,
            ],
            [
                'barang_id' => 13,
                'kategori_id' => 3,
                'barang_kode' => 'BSS',
                'barang_nama' => 'Salmon Slice',
                'harga_beli' => 25000,
                'harga_jual' => 30000,
            ],
            [
                'barang_id' => 14,
                'kategori_id' => 4,
                'barang_kode' => 'DRG',
                'barang_nama' => 'Dragon Fruit',
                'harga_beli' => 7000,
                'harga_jual' => 8000,
            ],
            [
                'barang_id' => 15,
                'kategori_id' => 5,
                'barang_kode' => 'BRS',
                'barang_nama' => 'Brownies Slice',
                'harga_beli' => 9000,
                'harga_jual' => 11000,
            ],
        ];

        DB::table('m_barang')->insert($data);
    }
}