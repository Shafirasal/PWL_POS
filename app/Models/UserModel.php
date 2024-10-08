<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_user';  // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan primary key dari tabel yang digunakan

    protected $fillable = ['level_id', 'username', 'nama', 'password', 'created_at', 'updated_at'];

    protected $hidden = ['password']; //jangan di tampilkan saat select

    protected $casts =['password' =>'hashed']; //csting password agar otomatis di hash

    
    public function level(): BelongsTo //Relasi ke tabel level
    {
        return $this->belongsTo (LevelModel ::class, 'level_id', 'level_id');
    }

    public function getRoleName(): string //Mendapatkan nama role
    {
        return $this->level->level_nama;
    }

    public function hasRole($role): bool // Cek apakah user memiliki role tertentu
    {
        return $this->level->level_kode == $role;
    }

    public function getRole()
    {
        return $this->level->level_kode;
    }
}
