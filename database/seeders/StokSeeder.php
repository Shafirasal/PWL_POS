<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Stok untuk barang dari Supplier 1: Indofood
            [
                'stok_id' => 1,
                'supplier_id' => 1, // Indofood
                'barang_id' => 1, // Chitato
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 2,
                'supplier_id' => 1, // Indofood
                'barang_id' => 2, // Indomilk
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 3,
                'supplier_id' => 1, // Indofood
                'barang_id' => 3, // Beef Slice
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 150,
            ],
            [
                'stok_id' => 4,
                'supplier_id' => 1, // Indofood
                'barang_id' => 4, // Frozen Durian
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 120,
            ],
            [
                'stok_id' => 5,
                'supplier_id' => 1, // Indofood
                'barang_id' => 5, // Delfi Dark Choco
                'user_id' => 3, // Staff/Kasir
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 300,
            ],

            // Stok untuk barang dari Supplier 2: OTGroup
            [
                'stok_id' => 6,
                'supplier_id' => 2, // OTGroup
                'barang_id' => 6, // Tango Wafer
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 100,
            ],
            [
                'stok_id' => 7,
                'supplier_id' => 2, // OTGroup
                'barang_id' => 7, // Beng-Beng Drink
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 250,
            ],
            [
                'stok_id' => 8,
                'supplier_id' => 2, // OTGroup
                'barang_id' => 8, // Fish Stick
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 180,
            ],
            [
                'stok_id' => 9,
                'supplier_id' => 2, // OTGroup
                'barang_id' => 9, // Apple Fuji
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 300,
            ],
            [
                'stok_id' => 10,
                'supplier_id' => 2, // OTGroup
                'barang_id' => 10, // Cheesecake Slice
                'user_id' => 3, // Staff/Kasir
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 400,
            ],

            // Stok untuk barang dari Supplier 3: Japfa Food
            [
                'stok_id' => 11,
                'supplier_id' => 3, // Japfa Food
                'barang_id' => 11, // Pineapple Snack
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 110,
            ],
            [
                'stok_id' => 12,
                'supplier_id' => 3, // Japfa Food
                'barang_id' => 12, // Yakult Mini
                'user_id' => 1, // Admin
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 130,
            ],
            [
                'stok_id' => 13,
                'supplier_id' => 3, // Japfa Food
                'barang_id' => 13, // Salmon Slice
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 140,
            ],
            [
                'stok_id' => 14,
                'supplier_id' => 3, // Japfa Food
                'barang_id' => 14, // Dragon Fruit
                'user_id' => 2, // Manager
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 200,
            ],
            [
                'stok_id' => 15,
                'supplier_id' => 3, // Japfa Food
                'barang_id' => 15, // Brownies Slice
                'user_id' => 3, // Staff/Kasir
                'stok_tanggal' => Carbon::now(),
                'stok_jumlah' => 300,
            ],
        ];

        DB::table('t_stok')->insert($data);
    }
}