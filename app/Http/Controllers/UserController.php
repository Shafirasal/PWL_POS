<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    public function index1()
    {
        // // tambah data user dengan Eloquent Model
        // $data = [
        //     'username' => 'customer-1',
        //     'nama' => 'Pelanggan',
        //     'password' => Hash::make('12345'), // mengenkripsi password
        //     'level_id' => 4
        // ];
        // UserModel::insert($data); // tambahkan data ke tabel m_user

        //ERROR
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tigas',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345')
        // ];

        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);


        // $user = UserModel:: find(1); // mencari dengan primary key 1
        // $user = UserModel:: where('level_id', 1) -> first();
        // $user = UserModel:: firstWhere('level_id', 1) -> first();

            
        // $user = UserModel:: findOr(1,['username', 'nama'], function(){
        //     abort(404);
        // });

        // $user = UserModel:: findOr(20,['username', 'nama'], function(){
        //     abort(404);
        // });

        //ERROR EXCEPTION
        // $user = UserModel::findOrFail(1);   
        
        // $user = UserModel::where('username', 'manager9')->firstOrFail();

        // //RETREIVING AGGREGRATES
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);

        
        // $totalUser = UserModel::where('level_id', 2)-> count(); //amvil total jumlah pengguna dengan leve-id 2
        // $userList = UserModel::where('level_id', 2)->get(); //amvbl daftar pengguna dengan level-id 2

        // return view('user', ['totalUser' => $totalUser, 'userlist' => $userList]);

        // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ]
        // );

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //         ]
        // );
        // $user -> save();
        
        // return view('user', ['data' => $user]);

        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        
        // $user->username = 'manager56';
        
        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('nama'); // false
        // $user->isDirty(['nama', 'username']); // true
        
        // $user->isClean(); // false
        // $user->isClean('username'); // false
        // $user->isClean('nama'); // true
        // $user->isClean(['nama', 'username']); // false
        
        // $user->save();
        
        // $user->isDirty(); // false
        // $user->isClean(); // true
        // dd($user->isDirty());
        
        

        // $user = UserModel::create([
        //     'username' => 'manager11',
        //     'nama' => 'Manager11',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        
        // $user->username = 'manager12';
        
        // $user->save();
        
        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('nama'); // false
        // dd($user->wasChanged(['nama', 'username'])); // true
        
        $user=UserModel::all();
        return view('user', ['data'=> $user]);
    }

    public function tambah(){
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id){
        $user = UserModel :: find($id);
        return view ('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user = UserModel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user');
    }
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }

    // public function index(){
    //     $user = UserModel :: with ('level')->get();
    //     dd($user);
    // }

    // public function index(){
    //     $user = UserModel :: with ('level')->get();
    //     return view('user', ['data'=>$user]);
    // }

       
    //menampilkan halaman awal user
    public function index() {

        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; //set menu yag sedang aktif
            
        $level = LevelModel::all(); //ambil data level untuk filter
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');
    
    //Filter data user berdasarkan level_id
    if ($request->level_id) {
        $users->where('level_id', $request->level_id);
    }
    return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('aksi', function ($user) {
            // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
            //     . csrf_field() . method_field('DELETE') .
            //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            $btn = '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }


    //menampilkan halaman form tambah user
    public function create() {

        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all(); //ambil dta level untuk ditampilkan diform
        $activeMenu = 'user'; //set menu yag sedang aktif

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page,'level' =>  $level, 'activeMenu' => $activeMenu]);
        }


    //menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max: 100', //nama harus diisi, berupa string, dan maksimal 100 karakter
            'password'  => 'required|min:5', // password harus diisi dan minimal 5 karakter
            'level_id'  => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'level_id'  => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    // Menampilkan detail user
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }


        // Menampilkan halaman fore edit user 
        public function edit(string $id)
        {
            $user = UserModel::find($id);
            $level = LevelModel::all();
            $breadcrumb = (object) [
                'title' => 'Edit User',
                'list' => ['Home', 'User', 'Edit']
            ];
            $page = (object) [
                "title" => 'Edit user'
            ];
            $activeMenu = 'user'; // set menu yang sedang aktif
            return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
        }
    
        //menyimpan perubahan data user
        public function update(Request $request, string $id)
        {
            $request->validate([
                // username harus diisi, berupa string, minimal 3 karakter,
                // dan bernilai unik di tabel_user kolom username kecuali untuk user dengan id yang sedang diedit
                'username'  => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
                'nama'      => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
                'password'  => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
                'level_id'  => 'required|integer' //level_id harus diisi dan berupa angka
            ]);
            UserModel::find($id)->update([
                'username'  => $request->username,
                'nama'      => $request->nama,
                'password'  => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                'level_id'  => $request->level_id
            ]);
            return redirect('/user')->with("success", "Data user berhasil diubah");
        }
    
        // Menghapus data user 
        public function destroy(string $id)
        {
            $check = UserModel::find($id);
            if (!$check) {      // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
                return redirect('/user')->with('error', 'Data user tidak ditemukan');
            }
            try {
                UserModel::destroy($id); // Hapus data level
                return redirect('/user')->with('success', 'Data user berhasil dihapus');
            }   catch (\Illuminate\Database\QueryException $e) {
                // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
                return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

        public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }


    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5'
            ];
    
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
    
            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }
    
    //menampilkan halaman form edit user ajax
    public function edit_ajax(string $id){
        $user = UserModel :: find($id);
        $level = LevelModel:: select('level_id', 'level_nama')->get();

        return view('user.edit_ajax',['user'=> $user, 'level'=> $level]);
    }

    //update ajax
    public function update_ajax(Request $request, $id)
    {
        // Cek apakah request berasal dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:5|max:20'
            ];
    
            // Gunakan Illuminate\Support\Facades\Validator
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // Respon JSON, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // Menunjukkan field mana yang error
                ]);
            }
    
            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // Jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    
        return redirect('/');
    }
    

    public function confirm_ajax(string $id){
        $user = UserModel::find($id);
    
        return view('user.confirm_ajax', ['user' => $user]);
    }
    
    //delete function
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

//     public function upload(Request $request)
//     {
//         // Validasi file
//         $request->validate([
//             'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//         ]);

//         // Simpan gambar ke folder public
//         $imageName = time().'.'.$request->profile_image->extension();  
//         $request->profile_image->move(public_path('images/profile'), $imageName);

//         // Simpan path gambar ke database
//         $user = Auth::user();
//         $user->profile_image = $imageName;
//         $user->save();

//         return back()->with('success', 'Gambar profil berhasil diunggah');
//     }
    
// }

    // Menampilkan halaman profil
    public function showProfile()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $activeMenu = 'profile'; // Set active menu untuk halaman profile

        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home']
        ];

        return view('profile', compact('user', 'activeMenu', 'breadcrumb'));
    }

    // public function uploadProfilePicture(Request $request)
    // {
    //     $request->validate([
    //         'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $user = Auth::user();

    //     // Hapus gambar profil lama jika ada
    //     if ($user->profile_picture) {
    //         Storage::delete($user->profile_picture);
    //     }

    //     // Simpan gambar baru
    //     $path = $request->file('profile_picture')->store('profile_pictures');

    //     // Update path di database
    //     $user->profile_picture = $path;
    //     $user->save();

    //     return redirect()->route('profile')->with('success', 'Profile picture updated successfully.');
    // }

    // Menampilkan detail user
    public function show_ajax(String $id) {
        $user = UserModel::with('level')->find($id);
        return view('user.show_ajax', ['user' => $user]);
    }

    public function import()
{
    return view('user.import');
}

public function import_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'file_user' => ['required', 'mimes:xlsx', 'max:1024']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }
        $file = $request->file('file_user');
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
                        'level_id' => $value['A'],
                        'username' => $value['B'],
                        'nama' => $value['C'],
                        'password' => bcrypt($value['D']),
                        'created_at' => now(),
                    ];
                }
            }
            if (count($insert) > 0) {
                UserModel::insertOrIgnore($insert);
            }
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diimport'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ]);
        }
    }
    return redirect('/');
}

public function export_excel()
{
    $user = UserModel::select('level_id', 'username', 'nama', 'password')
        ->orderBy('level_id')
        ->with('level')
        ->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Username');
    $sheet->setCellValue('C1', 'Nama user');
    $sheet->setCellValue('D1', 'Password');
    $sheet->setCellValue('E1', 'level');

    $sheet->getStyle('A1:F1')->getFont()->setBold(true);

    $no = 1;
    $baris = 2;
    foreach ($user as $key => $value) {
        $sheet->setCellValue('A' . $baris, $no);
        $sheet->setCellValue('B' . $baris, $value->username);
        $sheet->setCellValue('C' . $baris, $value->nama);
        $sheet->setCellValue('D' . $baris, $value->password);
        $sheet->setCellValue('E' . $baris, $value->level->level_nama);
        $baris++;
        $no++;
    }

    foreach (range('A', 'E') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $sheet->setTitle('Data user');
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $filename = 'Data user ' . date('Y-m-d H:i:s') . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');
    $writer->save('php://output');
    exit;
}

public function export_pdf()
{
    $user = UserModel::select('level_id', 'username', 'nama')
        ->orderBy('level_id')
        ->orderBy('username')
        ->with('level')
        ->get();
    $pdf = Pdf::loadView('user.export_pdf', ['user' => $user]);
    $pdf->setPaper('a4', 'portrait');
    $pdf->setOption("isRemoteEnabled", true);
    return $pdf->stream('Data user' . date('Y-m-d H:i:s') . '.pdf');
}

}