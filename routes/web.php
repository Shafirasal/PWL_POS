<?php

use App\Htpp\Controller\UserController as ControllerUserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Database\Seeders\KategoriSeeder;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route:: get('/level', [LevelController::class, 'index']);
// Route:: get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController ::class, 'index']);

// Route::get('/user/tambah', [UserController ::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController ::class, 'tambah_simpan']);

// route:: get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);


// //delete
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// //JS 5 LAYOUTING
// Route::get('/', [WelcomeController::class,'index']);



Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'store']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group ini harus login dulu
    // masukkan semua route yang perlu autentikasi di sini

    Route::get('/', [WelcomeController::class, 'index']);

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);          // menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']);      // menampilkan data user dalam bentuk json untuk datatables
        Route::get('/create', [UserController::class, 'create']);   // menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']);         // menyimpan data user baru
        Route::get('/create_ajax', [UserController::class, 'create_ajax']);   // menampilkan halaman form tambah user
        Route::post('/ajax', [UserController::class, 'store_ajax']);         // menyimpan data user baru
        Route::get('/{id}', [UserController::class, 'show']);       // menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']);  // menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']);     // menyimpan perubahan data user
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);  // menampilkan halaman form edit user
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);     // menyimpan perubahan data user
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);     // menyimpan perubahan data user
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // menghapus data user
        Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']); // menampilkan detail user via ajax
        Route::get('/import', [UserController::class, 'import']);
        Route::get('/user/export_excel', [UserController::class, 'export_excel']); // export excel
        Route::get('/user/export_pdf', [UserController::class, 'export_pdf']);
    });

    // Route::group(['prefix' => 'level'], function () {
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);          // menampilkan halaman awal level
        Route::post('/level/list', [LevelController::class, 'list']);      // menampilkan data level dalam bentuk json untuk datatables
        Route::get('/level/create', [LevelController::class, 'create']);   // menampilkan halaman form tambah level
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level', [LevelController::class, 'store']);         // menyimpan data level baru
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']);
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
        Route::get('/level/{id}', [LevelController::class, 'show']);       // menampilkan detail level
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);  // menampilkan halaman form edit level
        Route::put('/level/{id}', [LevelController::class, 'update']);     // menyimpan perubahan data level
        Route::delete('/level/{id}', [LevelController::class, 'destroy']); // menghapus data level
        Route::get('level/{id}/show_ajax', [LevelController::class, 'show_ajax']);
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']); // export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
        

    });


    // Route::group(['prefix' => 'kategori'], function () {
        Route::middleware(['authorize:ADM,MNG'])->group(function () {
            Route::get('/kategori', [KategoriController::class, 'index']);          // menampilkan halaman awal kategori
            Route::post('/kategori/list', [KategoriController::class, 'list']);      // menampilkan data kategori dalam bentuk json untuk datatables
            Route::get('/kategori/create', [KategoriController::class, 'create']);   // menampilkan halaman form tambah kategori
            Route::get('/kategori/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/kategori/ajax', [KategoriController::class, 'store_ajax']);
            Route::post('/kategori', [KategoriController::class, 'store']);         // menyimpan data kategori baru
            Route::get('/kategori/import', [KategoriController::class, 'import']);
            Route::post('/kategori/import_ajax', [KategoriController::class, 'import_ajax']);
            Route::get('/kategori/export_excel', [KategoriController::class, 'export_excel']); // export excel
            Route::get('/kategori/export_pdf', [KategoriController::class, 'export_pdf']); // export pdf
            Route::get('/kategori/{id}', [KategoriController::class, 'show']);       // menampilkan detail kategori
            Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit']);  // menampilkan halaman form edit kategori
            Route::put('/kategori/{id}', [KategoriController::class, 'update']);     // menyimpan perubahan data kategori
            Route::get('/kategori/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
            Route::put('/kategori/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
            Route::get('/kategori/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
            Route::delete('/kategori/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
            Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
        });

    // Route::group(['prefix' => 'barang'], function () {
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);          // menampilkan halaman awal barang
        Route::post('/barang/list', [BarangController::class, 'list']);      // menampilkan data barang dalam bentuk json untuk datatables
        Route::get('/barang/create', [BarangController::class, 'create']);   // menampilkan halaman form tambah barang
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/barang', [BarangController::class, 'store']);         // menyimpan data barang baru
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);
        Route::get('/barang/{id}', [BarangController::class, 'show']);       // menampilkan detail barang
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);  // menampilkan halaman form edit barang
        Route::put('/barang/{id}', [BarangController::class, 'update']);     // menyimpan perubahan data barang
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']);
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
        Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // menghapus data barang
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel',[BarangController::class,'export_excel']);//export excel
        Route::get('/barang/export_pdf',[BarangController::class,'export_pdf']);//export pdf
    });

    // Route::group(['prefix' => 'supplier'], function () {
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/supplier', [SupplierController::class, 'index']);          // menampilkan halaman awal supplier
        Route::post('/supplier/list', [SupplierController::class, 'list']);      // menampilkan data supplier dalam bentuk json untuk datatables
        Route::get('/supplier/create', [SupplierController::class, 'create']);   // menampilkan halaman form tambah supplier
        Route::get('/supplier/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/supplier', [SupplierController::class, 'store']);         // menyimpan data supplier baru
        Route::post('/supplier/ajax', [SupplierController::class, 'store_ajax']);
        Route::get('/supplier/{id}', [SupplierController::class, 'show']);       // menampilkan detail supplier
        Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);  // menampilkan halaman form edit supplier
        Route::put('/supplier/{id}', [SupplierController::class, 'update']);     // menyimpan perubahan data supplier
        Route::get('/supplier/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
        Route::put('/supplier/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
        Route::get('/supplier/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
        Route::delete('/supplier/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
        Route::delete('/supplier/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
        Route::post('/supplier/import_ajax', [SupplierController::class, 'import_ajax']);
        Route::get('/supplier/export_excel', [SupplierController::class, 'export_excel']); // export excel
        Route::get('/supplier/export_pdf', [SupplierController::class, 'export_pdf']); // export pdf
    });

    // Route::group(['prefix' => 'stok'], function () {
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
        Route::get('/stok', [StokController::class, 'index']);          // menampilkan halaman awal stok
        Route::post('/stok/list', [StokController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
        Route::get('/stok/create', [StokController::class, 'create']);   // menampilkan halaman form tambah stok
        Route::get('/stok/create_ajax', [StokController::class, 'create_ajax']);
        Route::post('/stok/ajax', [StokController::class, 'store_ajax']);
        Route::post('/stok', [StokController::class, 'store']);         // menyimpan data stok baru
        Route::get('/stok/import', [StokController::class, 'import']);
        Route::post('/stok/import_ajax', [StokController::class, 'import_ajax']);
        Route::get('/stok/export_excel', [StokController::class, 'export_excel']); // export excel
        Route::get('/stok/export_pdf', [StokController::class, 'export_pdf']); // export pdf
        Route::get('/stok/{id}', [StokController::class, 'show']);       // menampilkan detail stok
        Route::get('/stok/{id}/edit', [StokController::class, 'edit']);  // menampilkan halaman form edit stok
        Route::put('/stok/{id}', [StokController::class, 'update']);     // menyimpan perubahan data stok
        Route::get('/stok/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
        Route::put('/stok/{id}/update_ajax', [StokController::class, 'update_ajax']);
        Route::get('/stok/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
        Route::delete('/stok/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
        Route::delete('/stok/{id}', [StokController::class, 'destroy']); // menghapus data stok
    });

    
    Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
        // Rute untuk avatar
        Route::get('/profile/avatar', [ProfileController::class, 'editAvatar']);
        Route::post('/profile/avatar/store', [ProfileController::class, 'updateAvatar']); // Ubah url untuk update avatar
        
        // Rute untuk profil
        Route::get('/profile/profileEdit', [ProfileController::class, 'editProfile']);
        Route::post('/profile/profileEdit/store', [ProfileController::class, 'updateProfile']); // Ubah url untuk update profil
    });
    
        // Route::group(['prefix' => 'penjualan'], function () {
            Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
                Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
                Route::post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
                Route::get('/penjualan/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
                Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
                Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
                Route::post('/penjualan', [PenjualanController::class, 'store']);         // menyimpan data stok baru
                Route::get('/penjualan/import', [PenjualanController::class, 'import']);
                Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
                Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
                Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
                Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
                Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
                Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
                Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
                Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
                Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
                Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
                Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
                Route::get('/penjualan/{id}/show_ajax', [PenjualanController::class, 'show_ajax']); //menampilkan detail dengan ajax
                Route::post('/penjualan/detail/list', [PenjualanDetailController::class, 'list']);

            });

            Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
                Route::get('/detail', [PenjualanDetailController::class, 'index']);          // menampilkan halaman awal stok
                Route::post('/detail/list', [PenjualanDetailController::class, 'list']);  // menampilkan halaman form tambah stok
                Route::get('/detail/create_ajax', [PenjualanDetailController::class, 'create_ajax']);
                Route::post('/detail/ajax', [PenjualanDetailController::class, 'store_ajax']);       // menyimpan data stok baru
                Route::get('/detail/import', [PenjualanDetailController::class, 'import']);
                Route::post('/detail/import_ajax', [PenjualanDetailController::class, 'import_ajax']);
                Route::get('/detail/export_excel', [PenjualanDetailController::class, 'export_excel']); // export excel
                Route::get('/detail/export_pdf', [PenjualanDetailController::class, 'export_pdf']); // export pdf
                Route::get('/detail/{id}', [PenjualanDetailController::class, 'show']);    // menyimpan perubahan data stok
                Route::get('/detail/{id}/edit_ajax', [PenjualanDetailController::class, 'edit_ajax']);
                Route::put('/detail/{id}/update_ajax', [PenjualanDetailController::class, 'update_ajax']);
                Route::get('/detail/{id}/delete_ajax', [PenjualanDetailController::class, 'confirm_ajax']);
                Route::delete('/detail/{id}/delete_ajax', [PenjualanDetailController::class, 'delete_ajax']);
                Route::delete('/detail/{id}', [PenjualanDetailController::class, 'destroy']); // menghapus data stok
            });
 

    // Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    //     Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');// Menampilkan halaman profil
    // Route::post('/profile/upload', [ProfileController::class, 'upload'])->name('profile.upload'); // Menangani upload gambar
    // Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Mengupdate nama dan password
    // });
    

    // Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    //     // Route GET untuk menampilkan halaman update avatar
    //     Route::get('/profile/avatar', [ProfileController::class, 'showAvatar']);
    
    //     // Route POST untuk memperbarui avatar
    //     Route::post('/profile/avatar', [ProfileController::class, 'update']);
    
    //     // Route GET untuk menampilkan halaman profil pengguna
    //     Route::get('/profile/profile', [ProfileController::class, 'showProfile']);
    
    //     // Route POST untuk memperbarui data profil
    //     Route::post('/profile/profile', [ProfileController::class, 'updateProfile']);
    // });
    
    // Route::middleware(['auth'])->group(function () {
    //     // Route untuk halaman edit avatar
    //     Route::get('/avatar', [ProfileController::class, 'showAvatar']);
        
    //     // Route untuk halaman edit profil
    //     Route::get('/profile', [ProfileController::class, 'showProfile']);
        
    //     // Route untuk pembaruan avatar (POST)
    //     Route::post('/avatar/update', [ProfileController::class, 'updateAvatar']);
        
    //     // Route untuk pembaruan profil (POST)
    //     Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    // });
    


    

    
    

});
// Route::group(['prefix' => 'stok'], function () {
//     Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal stok
//     Route::post('/list', [StokController::class, 'list']); // menampilkan data stok dalam bentuk json untuk datatables
//     Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah stok
//     Route::get('/create_ajax', [StokController::class, 'create_ajax']);
//     Route::post('/', [StokController::class, 'store']); // menyimpan data stok baru
//     Route::post('/ajax', [StokController::class, 'store_ajax']);
//     Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail stok
//     Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit stok
//     Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data stok
//     Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
//     Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data stok
// });






// <?php

// use App\Htpp\Controller\UserController as ControllerUserController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\BarangController;
// use App\Http\Controllers\KategoriController;
// use App\Http\Controllers\LevelController;
// use App\Http\Controllers\StokController;
// use App\Http\Controllers\SupplierController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\WelcomeController;
// use Database\Seeders\KategoriSeeder;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | Web Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register web routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "web" middleware group. Make something great!
// |
// */

// Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

// Route::get('login', [AuthController::class, 'login'])->name('login');
// Route::post('login', [AuthController::class, 'postlogin']);
// Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');
// Route::get('register', [AuthController::class, 'register']);
// Route::post('register', [AuthController::class, 'store']);

// Route::middleware(['auth'])->group(function(){

//     Route::get('/', [WelcomeController::class, 'index']);

//     Route::group(['prefix' => 'user'], function(){
//         Route::get('/', [UserController::class, 'index']); //menampilkan halaman awal user
//         Route::post('/list', [UserController::class, 'list']); //menampilkan data user dalam bentuk json untuk datatables
//         Route::get('/create', [UserController::class, 'create']); //menampilkan halaman form tambah user
//         Route::post('/', [UserController::class, 'store']); //menyimpan data user baru
//         Route::get('/create_ajax', [UserController::class, 'create_ajax']); //menampilkan halaman form tambah user Ajax
//         Route::post('/ajax', [UserController::class, 'store_ajax']); //menyimpan data user baru Ajax
//         Route::get('/{id}', [UserController::class, 'show']); //menampilkan detail user
//         Route::get('/{id}/edit', [UserController::class, 'edit']); //menampilkan halaman form edit user
//         Route::put('/{id}', [UserController::class, 'update']); //menampilkan perubahan data user
//         Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); //Menampilkan halaman form edit user Ajax
//         Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); //Menampilkan halaman form edit user Ajax
//         Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete user Ajax
//         Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //untuk menampilkan form confirm delete user Ajax
//         Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
//     });
    
//     Route::middleware(['authorize:ADM'])->group(function(){
//         Route::get('/', [LevelController::class, 'index']); // menampilkan halaman awal level
//         Route::post('/list', [LevelController::class, 'list']); // menampilkan data level dalam bentuk json untuk datatables
//         Route::get('/create', [LevelController::class, 'create']); // menampilkan halaman form tambah level
//         Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
//         Route::post('/', [LevelController::class, 'store']); // menyimpan data level baru
//         Route::post('/ajax', [LevelController::class, 'store_ajax']);
//         Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);
//         Route::get('/{id}', [LevelController::class, 'show']); // menampilkan detail level
//         Route::get('/{id}/edit', [LevelController::class, 'edit']); // menampilkan halaman form edit level
//         Route::put('/{id}', [LevelController::class, 'update']); // menyimpan perubahan data level
//         Route::delete('/{id}', [LevelController::class, 'destroy']); // menghapus data level
//     });
    
//     Route::middleware(['authorize:ADM,MNG'])->group(function () {
//         Route::get('/', [KategoriController::class, 'index']); // menampilkan halaman awal kategori
//         Route::post('/list', [KategoriController::class, 'list']); // menampilkan data kategori dalam bentuk json untuk datatables
//         Route::get('/create', [KategoriController::class, 'create']); // menampilkan halaman form tambah kategori
//         Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
//         Route::post('/', [KategoriController::class, 'store']); // menyimpan data kategori baru
//         Route::post('/ajax', [KategoriController::class, 'store_ajax']);
//         Route::get('/{id}', [KategoriController::class, 'show']); // menampilkan detail kategori
//         Route::get('/{id}/edit', [KategoriController::class, 'edit']); // menampilkan halaman form edit kategori
//         Route::put('/{id}', [KategoriController::class, 'update']); // menyimpan perubahan data kategori
//         Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
//         Route::delete('/{id}', [KategoriController::class, 'destroy']); // menghapus data kategori
//     });
    
//     Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
//         Route::get('/', [BarangController::class, 'index']); // menampilkan halaman awal barang
//         Route::post('/list', [BarangController::class, 'list']); // menampilkan data barang dalam bentuk json untuk datatables
//         Route::get('/create', [BarangController::class, 'create']); // menampilkan halaman form tambah barang
//         Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
//         Route::post('/', [BarangController::class, 'store']); // menyimpan data barang baru
//         Route::post('/ajax', [BarangController::class, 'store_ajax']);
//         Route::get('/{id}', [BarangController::class, 'show']); // menampilkan detail barang
//         Route::get('/{id}/edit', [BarangController::class, 'edit']); // menampilkan halaman form edit barang
//         Route::put('/{id}', [BarangController::class, 'update']); // menyimpan perubahan data barang
//         Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
//         Route::delete('/{id}', [BarangController::class, 'destroy']); // menghapus data barang
//     });
    
//     Route::middleware(['authorize:ADM,MNG'])->group(function () {
//         Route::get('/', [SupplierController::class, 'index']); // menampilkan halaman awal supplier
//         Route::post('/list', [SupplierController::class, 'list']); // menampilkan data supplier dalam bentuk json untuk datatables
//         Route::get('/create', [SupplierController::class, 'create']); // menampilkan halaman form tambah supplier
//         Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
//         Route::post('/', [SupplierController::class, 'store']); // menyimpan data supplier baru
//         Route::post('/ajax', [SupplierController::class, 'store_ajax']);
//         Route::get('/{id}', [SupplierController::class, 'show']); // menampilkan detail supplier
//         Route::get('/{id}/edit', [SupplierController::class, 'edit']); // menampilkan halaman form edit supplier
//         Route::put('/{id}', [SupplierController::class, 'update']); // menyimpan perubahan data supplier
//         Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);
//         Route::delete('/{id}', [SupplierController::class, 'destroy']); // menghapus data supplier
//     });
    
//     Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
//         Route::get('/', [StokController::class, 'index']); // menampilkan halaman awal stok
//         Route::post('/list', [StokController::class, 'list']); // menampilkan data stok dalam bentuk json untuk datatables
//         Route::get('/create', [StokController::class, 'create']); // menampilkan halaman form tambah stok
//         Route::get('/create_ajax', [StokController::class, 'create_ajax']);
//         Route::post('/', [StokController::class, 'store']); // menyimpan data stok baru
//         Route::post('/ajax', [StokController::class, 'store_ajax']);
//         Route::get('/{id}', [StokController::class, 'show']); // menampilkan detail stok
//         Route::get('/{id}/edit', [StokController::class, 'edit']); // menampilkan halaman form edit stok
//         Route::put('/{id}', [StokController::class, 'update']); // menyimpan perubahan data stok
//         Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
//         Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
//         Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
//         Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);
//         Route::delete('/{id}', [StokController::class, 'destroy']); // menghapus data stok
//     });
// });

