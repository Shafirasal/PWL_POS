@extends('layouts.template') 

@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"></div> 
      </div> 
      <div class="card-body"> 
        @empty($penjualan) 
            <div class="alert alert-danger alert-dismissible"> 
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> 
                Data penjualan yang Anda cari tidak ditemukan. 
                <a href="{{ url('penjualan') }}" class="btn btn-sm btn-danger mt-2">Kembali</a>
            </div> 
        @else 
            <table class="table table-bordered table-striped table-hover table-sm"> 
                <tr> 
                    <th>ID Penjualan</th> 
                    <td>{{ $penjualan->penjualan_id }}</td> 
                </tr> 
                <tr> 
                    <th>Kode Penjualan</th> 
                    <td>{{ $penjualan->penjualan_kode }}</td> 
                </tr> 
                <tr>
                    <th>Tanggal Penjualan</th>
                    <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d-m-Y') }}</td>
                </tr>
                <tr> 
                    <th>Nama Pembeli</th> 
                    <td>{{ $penjualan->pembeli }}</td> 
                </tr> 
                <tr> 
                    <th>Nama User</th> 
                    <td>{{ optional($penjualan->user)->user_id }}</td> 
                </tr> 
            </table> 
        @endempty 
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a> 
    </div> 
  </div> 
@endsection 

