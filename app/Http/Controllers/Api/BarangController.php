<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menampilkan semua data barang
    public function index(){
        return BarangModel::all();
    }

    // Menyimpan data barang baru
    public function store(Request $request){
        $barang = BarangModel::create($request->all());
        return response()->json($barang, 201);
    }

    // Menampilkan data satu barang berdasarkan ID
    public function show(BarangModel $barang){
        return $barang;
    }

    // Memperbarui data barang yang sudah ada
    public function update(Request $request, BarangModel $barang){
        $barang->update($request->all());
        return $barang;
    }

    // Menghapus data barang berdasarkan ID
    public function destroy(BarangModel $barang){
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus',
        ]);
    }
}
