<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
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

        // $user = UserModel::findOrFail(1);   
        
        $user = UserModel::where('username', 'manager9')->firstOrFail();


        // // coba akses model UserModel
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}
