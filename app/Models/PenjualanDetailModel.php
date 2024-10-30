<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PenjualanDetailModel extends Model

{
    
   protected $table = 't_penjualan_detail';
    protected $primaryKey = 'detail_id';

    protected $fillable = ['penjualan_id','barang_id', 'harga', 'jumlah'];


    public function penjualan():BelongsTo
    {
        return $this->belongsTo(PenjualanModel::class, 'penjualan_id','penjualan_id');
    }
    public function barang():BelongsTo
    {
        return $this->belongsTo(BarangModel::class, 'barang_id','barang_id');
    }

}

?>