{{-- @section('content') 
<div class="card card-outline card-primary"> 
    <div class="card-header"> 
        <h3 class="card-title">Detail Penjualan</h3> <!-- Replace this with a static title or adjust as needed -->
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
                    <td id="penjualan-id">{{ $penjualan->penjualan_id }}</td> 
                </tr> 
                <tr> 
                    <th>Kode Penjualan</th> 
                    <td id="penjualan-kode">{{ $penjualan->penjualan_kode }}</td> 
                </tr> 
                <tr>
                    <th>Tanggal Penjualan</th>
                    <td id="penjualan-tanggal">{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d-m-Y') }}</td>
                </tr>
                <tr> 
                    <th>Nama Pembeli</th> 
                    <td id="penjualan-pembeli">{{ $penjualan->pembeli }}</td> 
                </tr> 
                <tr> 
                    <th>Nama User</th> 
                    <td id="penjualan-user">{{ optional($penjualan->user)->user_id }}</td> 
                </tr> 
            </table> 
        @endempty 
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a> 
    </div> 
</div> --}}

@if ($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right col-3">ID Penjualan</th>
                        <td class="col-9">{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kode Penjualan</th>
                        <td class="col-9">{{ $penjualan->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Tanggal Penjualan</th>
                        <td class="col-9" id="penjualan-tanggal">{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Pembeli</th>
                        <td class="col-9">{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama User</th>
                        <td class="col-9">{{ optional($penjualan->user)->user_id }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Kembali</button>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data penjualan tidak ditemukan.
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@endif
