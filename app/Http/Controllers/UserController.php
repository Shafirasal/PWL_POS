<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
            $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                . csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
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
                'password' => 'required|min:6'
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
    
}
