<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang'; // set menu yang sedang aktif

        $kategori = KategoriModel::all(); // ambil data kategori untuk filter kategori
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->with('kategori');

        // filter data barang berdasarkan kategori_id
        if ($request->kategori_id) {
            $barang->where('kategori_id', $request->kategori_id);
        }
        
        return DataTables::of($barang)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/barang/' . $barang->barang_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm
                    (\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah barang 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Barang baru'
        ];

        $kategori = KategoriModel::all(); // ambil data kategori untuk ditampilkan di form
        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            // barangname harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_barang kolom barangname
            'kategori_id'   => 'required|integer',
            'barang_kode'   => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'   => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_beli'    => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_jual'    => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
        BarangModel::create([
            'kategori_id'   => $request-> kategori_id,
            'barang_kode'   => $request-> barang_kode,
            'barang_nama'   => $request-> barang_nama,
            'harga_beli'    => $request-> harga_beli,
            'harga_jual'    => $request-> harga_jual
        ]);
        return redirect('/barang')->with('success', 'Data Barang berhasil disimpan');
    }

    // Menampilkan detail barang
    public function show(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id);
        $breadcrumb = (object) ['title' => 'Detail Barang', 'list' => ['Home', 'Barang', 'Detail']];
        $page = (object) ['title' => 'Detail barang'];
        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman fore edit barang 
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            "title" => 'Edit Barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id'   => 'required|integer',
            'barang_kode'   => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'   => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_beli'    => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'harga_jual'    => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
        BarangModel::find($id)->update([
            'kategori_id'   => $request-> kategori_id,
            'barang_kode'   => $request-> barang_kode,
            'barang_nama'   => $request-> barang_nama,
            'harga_beli'    => $request-> harga_beli,
            'harga_jual'    => $request-> harga_jual
        ]);
        return redirect('/barang')->with("success", "Data Barang berhasil diubah");
    }

    // Menghapus data barang 
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {      // untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id); // Hapus data kategori
            return redirect('/barang')->with('success', 'Data Barangbarang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error

            return redirect('/barang')->with('error', 'Data Barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}