<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class PenjualanDetailController extends Controller
{
    // Menampilkan halaman utama detail penjualan
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Detail Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar Detail Penjualan yang terdaftar dalam sistem'
        ];
        $penjualan = PenjualanModel::all();
        $detail = PenjualanDetailModel::all();
        $barang = BarangModel::all();
        return view('penjualan.detail', compact('activeMenu', 'breadcrumb', 'penjualan', 'detail', 'barang', 'page'));
    }

    // Menampilkan data detail penjualan dalam format DataTables
    public function list(Request $request)
    {
        $detail = PenjualanDetailModel::with(['barang', 'penjualan'])
            ->select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah');

        if ($request->barang_id) {
            $detail->where('barang_id', $request->barang_id);
        }

        return DataTables::of($detail)
            ->addIndexColumn()
            ->addColumn('aksi', function ($detail) {
                $btn  = '<a onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show(string $id)
    {
        $detail = PenjualanDetailModel::with('barang')->find($id);
        if (!$detail) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $breadcrumb = (object) ['title' => 'Detail Detail Penjualan', 'list' => ['Home', 'Penjualan', 'Detail']];
        $page = (object) ['title' => 'Detail Detail Penjualan'];
        $activeMenu = 'detail';
        return view('detail.show', compact('breadcrumb', 'page', 'detail', 'activeMenu'));
    }

    // Menampilkan form tambah data detail penjualan
    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.create_ajax', compact('barang', 'penjualan'));
    }

    // Menyimpan data detail penjualan menggunakan AJAX
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer|exists:t_penjualan,penjualan_id',
                'barang_id'    => 'required|integer|exists:t_barang,barang_id',
                'harga'        => 'required|numeric|min:1',
                'jumlah'       => 'required|numeric|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                PenjualanDetailModel::create($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data detail penjualan berhasil disimpan'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('/');
    }

    // Menampilkan form edit data detail penjualan
    public function edit_ajax(string $id)
    {
        $detail = PenjualanDetailModel::find($id);
        if (!$detail) {
            return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.edit_ajax', compact('detail', 'barang', 'penjualan'));
    }

    // Mengupdate data detail penjualan menggunakan AJAX
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer|exists:t_penjualan,penjualan_id',
                'barang_id'    => 'required|integer|exists:t_barang,barang_id',
                'harga'        => 'required|numeric|min:1',
                'jumlah'       => 'required|numeric|min:1'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $detail = PenjualanDetailModel::find($id);
            if (!$detail) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            try {
                $detail->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('/');
    }

    // Menghapus data detail penjualan menggunakan AJAX
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $detail = PenjualanDetailModel::find($id);
            if (!$detail) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            try {
                $detail->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('/');
    }

    // Menampilkan halaman import detail penjualan
    public function import()
    {
        return view('detail.import');
    }

    // Menghandle import detail penjualan menggunakan AJAX
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_detail' => 'required|mimes:xlsx|max:1024'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            try {
                $file = $request->file('file_detail');
                $reader = IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);
                $insert = [];

                foreach ($data as $index => $value) {
                    if ($index > 1) {
                        $insert[] = [
                            'penjualan_id' => $value['A'],
                            'barang_id'    => $value['B'],
                            'harga'        => $value['C'],
                            'jumlah'       => $value['D'],
                            'created_at'   => now(),
                        ];
                    }
                }

                if (!empty($insert)) {
                    PenjualanDetailModel::insertOrIgnore($insert);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil diimport'
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat mengimport data: ' . $e->getMessage()
                ], 500);
            }
        }

        return redirect('/');
    }

    // Menampilkan data detail penjualan dalam format PDF
    public function export_pdf()
    {
        $detail = PenjualanDetailModel::with('barang')->orderBy('detail_id')->get();
        $pdf = Pdf::loadView('detail.export_pdf', compact('detail'))
            ->setPaper('a4', 'portrait')
            ->setOption("isRemoteEnabled", true);

        return $pdf->stream('Data Detail Penjualan ' . date('Y-m-d H:i:s') . '.pdf');
    }

    // Menampilkan data detail penjualan dalam format Excel
    public function export_excel()
    {
        $detail = PenjualanDetailModel::with('barang')->orderBy('detail_id')->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga');
        $sheet->setCellValue('E1', 'Jumlah');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi Data
        $baris = 2;
        foreach ($detail as $index => $item) {
            $sheet->setCellValue('A' . $baris, $index + 1);
            $sheet->setCellValue('B' . $baris, $item->penjualan->penjualan_kode ?? '');
            $sheet->setCellValue('C' . $baris, $item->barang->barang_nama ?? '');
            $sheet->setCellValue('D' . $baris, $item->harga);
            $sheet->setCellValue('E' . $baris, $item->jumlah);
            $baris++;
        }

        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Detail Penjualan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Detail Penjualan ' . date('Y-m-d H:i:s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        $writer->save('php://output');
        exit;
    }
}
