<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetail extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Transaction 1
            ['detail_id' => 1, 'penjualan_id' => 1, 'barang_id' => 1, 'harga' => 5500, 'jumlah' => 2],
            ['detail_id' => 2, 'penjualan_id' => 1, 'barang_id' => 2, 'harga' => 6500, 'jumlah' => 1],
            ['detail_id' => 3, 'penjualan_id' => 1, 'barang_id' => 3, 'harga' => 25000, 'jumlah' => 1],

            // Transaction 2
            ['detail_id' => 4, 'penjualan_id' => 2, 'barang_id' => 4, 'harga' => 18000, 'jumlah' => 3],
            ['detail_id' => 5, 'penjualan_id' => 2, 'barang_id' => 5, 'harga' => 12000, 'jumlah' => 1],
            ['detail_id' => 6, 'penjualan_id' => 2, 'barang_id' => 6, 'harga' => 4500, 'jumlah' => 5],

            // Transaction 3
            ['detail_id' => 7, 'penjualan_id' => 3, 'barang_id' => 7, 'harga' => 6000, 'jumlah' => 2],
            ['detail_id' => 8, 'penjualan_id' => 3, 'barang_id' => 8, 'harga' => 22000, 'jumlah' => 1],
            ['detail_id' => 9, 'penjualan_id' => 3, 'barang_id' => 9, 'harga' => 6000, 'jumlah' => 3],

            // Transaction 4
            ['detail_id' => 10, 'penjualan_id' => 4, 'barang_id' => 10, 'harga' => 10000, 'jumlah' => 2],
            ['detail_id' => 11, 'penjualan_id' => 4, 'barang_id' => 11, 'harga' => 5000, 'jumlah' => 4],
            ['detail_id' => 12, 'penjualan_id' => 4, 'barang_id' => 12, 'harga' => 3500, 'jumlah' => 5],

            // Transaction 5
            ['detail_id' => 13, 'penjualan_id' => 5, 'barang_id' => 13, 'harga' => 30000, 'jumlah' => 1],
            ['detail_id' => 14, 'penjualan_id' => 5, 'barang_id' => 14, 'harga' => 8000, 'jumlah' => 2],
            ['detail_id' => 15, 'penjualan_id' => 5, 'barang_id' => 15, 'harga' => 11000, 'jumlah' => 1],

            // Transaction 6
            ['detail_id' => 16, 'penjualan_id' => 6, 'barang_id' => 1, 'harga' => 5500, 'jumlah' => 2],
            ['detail_id' => 17, 'penjualan_id' => 6, 'barang_id' => 2, 'harga' => 6500, 'jumlah' => 1],
            ['detail_id' => 18, 'penjualan_id' => 6, 'barang_id' => 3, 'harga' => 25000, 'jumlah' => 1],

            // Transaction 7
            ['detail_id' => 19, 'penjualan_id' => 7, 'barang_id' => 4, 'harga' => 18000, 'jumlah' => 2],
            ['detail_id' => 20, 'penjualan_id' => 7, 'barang_id' => 5, 'harga' => 12000, 'jumlah' => 1],
            ['detail_id' => 21, 'penjualan_id' => 7, 'barang_id' => 6, 'harga' => 4500, 'jumlah' => 3],

            // Transaction 8
            ['detail_id' => 22, 'penjualan_id' => 8, 'barang_id' => 7, 'harga' => 6000, 'jumlah' => 4],
            ['detail_id' => 23, 'penjualan_id' => 8, 'barang_id' => 8, 'harga' => 22000, 'jumlah' => 1],
            ['detail_id' => 24, 'penjualan_id' => 8, 'barang_id' => 9, 'harga' => 6000, 'jumlah' => 5],

            // Transaction 9
            ['detail_id' => 25, 'penjualan_id' => 9, 'barang_id' => 10, 'harga' => 10000, 'jumlah' => 1],
            ['detail_id' => 26, 'penjualan_id' => 9, 'barang_id' => 11, 'harga' => 5000, 'jumlah' => 2],
            ['detail_id' => 27, 'penjualan_id' => 9, 'barang_id' => 12, 'harga' => 3500, 'jumlah' => 3],

            // Transaction 10
            ['detail_id' => 28, 'penjualan_id' => 10, 'barang_id' => 13, 'harga' => 30000, 'jumlah' => 1],
            ['detail_id' => 29, 'penjualan_id' => 10, 'barang_id' => 14, 'harga' => 8000, 'jumlah' => 2],
            ['detail_id' => 30, 'penjualan_id' => 10, 'barang_id' => 15, 'harga' => 11000, 'jumlah' => 1],
        ];

        DB::table('t_penjualan_detail')->insert($data);
    }
}