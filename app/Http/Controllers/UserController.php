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

         $data = [
            'level_id' => 2,
            'username' => 'manager_dua',
            'nama' => 'Manager 2',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);

        // coba akses model UserModel
        $user = UserModel::all(); // ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}
