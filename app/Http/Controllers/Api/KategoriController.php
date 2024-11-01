<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua data kategori
    public function index(){
        return KategoriModel::all();
    }

    // Menyimpan data kategori baru
    public function store(Request $request){
        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori, 201);
    }

    // Menampilkan data satu kategori berdasarkan ID
    public function show(KategoriModel $kategori){
        return $kategori;
    }

    // Memperbarui data kategori yang sudah ada
    public function update(Request $request, KategoriModel $kategori){
        $kategori->update($request->all());
        return $kategori;
    }

    // Menghapus data kategori berdasarkan ID
    public function destroy(KategoriModel $kategori){
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus',
        ]);
    }
}
