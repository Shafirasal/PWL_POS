<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\SupplierModel;
use App\Models\StockModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];
        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];
        $activeMenu = 'stok'; // set menu yang sedang aktif

        $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        $barang = BarangModel::all(); // ambil data supplier untuk filter supplier
        $user = UserModel::all(); // ambil data supplier untuk filter supplier
        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $stok = StockModel::select('stok_id', 'supplier_id', 'barang_id', 'user_id', 'stok_tanggal', 'stok_jumlah')
            ->with('supplier')
            ->with('barang')
            ->with('user');

        // filter data stok berdasarkan supplier_id
        if ($request->supplier_id) {
            $stok->where('supplier_id', $request->supplier_id);
        }
        if ($request->barang_id) {
            $stok->where('barang_id', $request->barang_id);
        }
        if ($request->user_id) {
            $stok->where('user_id', $request->user_id);
        }
        
        return DataTables::of($stok)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/stok/' . $stok->stok_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $stok->stok_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/stok/' . $stok->stok_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm
                    (\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    // Menampilkan halaman form tambah stok 
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Stok baru'
        ];

        $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        $barang = BarangModel::all(); // ambil data supplier untuk filter supplier
        $user = UserModel::all(); // ambil data supplier untuk filter supplier
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data stok baru
    public function store(Request $request)
    {
        $request->validate([
            // stokname harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_stok kolom stokname
            'supplier_id'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer',
            'stok_tanggal'  => 'required|date', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'stok_jumlah'    => 'required|integer' //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
        StockModel::create([
            'supplier_id'   => $request-> supplier_id,
            'barang_id'     => $request-> barang_id,
            'user_id'       => $request-> user_id,
            'stok_tanggal'  => $request-> stok_tanggal,
            'stok_jumlah'   => $request-> stok_jumlah
        ]);
        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    // Menampilkan detail stok
    public function show(string $id)
    {
        $stok = StockModel::with('supplier')->find($id);
        $breadcrumb = (object) ['title' => 'Detail stok', 'list' => ['Home', 'stok', 'Detail']];
        $page = (object) ['title' => 'Detail stok'];
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman fore edit stok 
    public function edit(string $id)
    {
        $stok = StockModel::find($id);
        $supplier = SupplierModel::all(); // ambil data supplier untuk filter supplier
        $barang = BarangModel::all(); // ambil data supplier untuk filter supplier
        $user = UserModel::all(); // ambil data supplier untuk filter supplier

        $breadcrumb = (object) [
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object) [
            "title" => 'Edit Stok'
        ];

        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok'=> $stok, 'supplier' => $supplier, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data stok
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer',
            'stok_tanggal'  => 'required|date', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'stok_jumlah'    => 'required|integer' //nama harus diisi, berupa string, dan maksimal 100 karakter
        ]);
        StockModel::find($id)->update([
            'supplier_id'   => $request-> supplier_id,
            'barang_id'     => $request-> barang_id,
            'user_id'       => $request-> user_id,
            'stok_tanggal'  => $request-> stok_tanggal,
            'stok_jumlah'   => $request-> stok_jumlah
        ]);
        return redirect('/stok')->with("success", "Data stok berhasil diubah");
    }

    // Menghapus data stok 
    public function destroy(string $id)
    {
        $check = StockModel::find($id);
        if (!$check) {      // untuk mengecek apakah data stok dengan id yang dimaksud ada atau tidak
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            StockModel::destroy($id); // Hapus data supplier
            return redirect('/stok')->with('success', 'Data stokstok berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error

            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}