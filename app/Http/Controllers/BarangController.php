<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'barang';
        $breadcrumb = (object)[
            'title' => 'Data Barang',
            'list'  => ['Home', 'Barang']
        ];

        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.index', [
            'activeMenu'  => $activeMenu,
            'breadcrumb'  => $breadcrumb,
            'kategori'    => $kategori
        ]);
    }

    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
                             ->with('kategori');

        $kategori_id = $request->input('filter_kategori');
        if (!empty($kategori_id)) {
            $barang->where('kategori_id', $kategori_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode'  => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode'],
                'barang_nama'  => ['required', 'string', 'max:100'],
                'harga_beli'   => ['required', 'numeric'],
                'harga_jual'   => ['required', 'numeric'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            BarangModel::create($request->all());
            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax($id)
    {
        $barang = BarangModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => ['required', 'integer', 'exists:m_kategori,kategori_id'],
                'barang_kode'  => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode,' . $id . ',barang_id'],
                'barang_nama'  => ['required', 'string', 'max:100'],
                'harga_beli'   => ['required', 'numeric'],
                'harga_jual'   => ['required', 'numeric'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = BarangModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->delete();
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_barang');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'kategori_id'  => $value['A'],
                            'barang_kode'  => $value['B'],
                            'barang_nama'  => $value['C'],
                            'harga_beli'   => $value['D'],
                            'harga_jual'   => $value['E'],
                            'created_at'   => now(),
                        ];
                    }
                }
            }

            if (count($insert) > 0) {
                BarangModel::insertOrIgnore($insert);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Data berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
        return redirect('/');
    }


    //fungsi export excel
    public function export_excel()
{
    // ambil data barang yang akan di export
    $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();

        // load library excel
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();   // ambil sheet yang aktif

    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Kode Barang');
    $sheet->setCellValue('C1', 'Nama Barang');
    $sheet->setCellValue('D1', 'Harga Beli');
    $sheet->setCellValue('E1', 'Harga Jual');
    $sheet->setCellValue('F1', 'Kategori');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true);   // bold header


    //looping data yang telah di dapat dr data base
    $no = 1;            // nomor data dimulai dari 1
    $baris = 2;         // baris data dimulai dari baris ke 2
        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->barang_kode);
            $sheet->setCellValue('C'.$baris, $value->barang_nama);
            $sheet->setCellValue('D'.$baris, $value->harga_beli);
            $sheet->setCellValue('E'.$baris, $value->harga_jual);
            $sheet->setCellValue('F'.$baris, $value->kategori->kategori_nama);  // ambil nama kategori
            $baris++;
            $no++;
        }

        //looping dan set lebar tiap kolom di excel untuk menyesuaikan dengan panjang karakter pada masing-masing kolom 
    foreach(range('A','F') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
     }
        

     //set nama sheet, dan proses untuk dapat di download oleh pengguna
     $sheet->setTitle('Data Barang'); // set title sheet

     $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
     $filename = 'Data Barang '.date('Y-m-d H:i:s').'.xlsx';
     
     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
     header('Content-Disposition: attachment;filename="'.$filename.'"');
     header('Cache-Control: max-age=0');
     header('Cache-Control: max-age=1');
     header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
     header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
     header('Cache-Control: cache, must-revalidate');
     header('Pragma: public');
     
     $writer->save('php://output');
     exit;
     
     // end function export_excel
     
    }

}

