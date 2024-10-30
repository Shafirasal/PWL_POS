@extends('layouts.template')

@section('content')
    <!-- Modal untuk Tambah/Edit Penjualan -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" 
         data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>

    <!-- Tabs Navigasi -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
               aria-controls="pills-home" aria-selected="true">Transaksi Penjualan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
               aria-controls="pills-profile" aria-selected="false">Detail Penjualan</a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <!-- Tab Transaksi Penjualan -->
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-success">Tambah Ajax</button>
                        <button onclick="modalAction('{{ url('/penjualan/import') }}')" class="btn btn-info">Import Penjualan</button>
                        <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning">
                            <i class="fa fa-file-pdf"></i> Export Penjualan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Filter User -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="">- Semua -</option>
                                        @foreach ($users as $item)
                                            <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">User</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Penjualan -->
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-penjualan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pembeli</th>
                                <th>Kode Penjualan</th>
                                <th>Tanggal</th>
                                <th>User</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab Detail Penjualan -->
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <button onclick="modalAction('{{ url('/detail/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
                        <button onclick="modalAction('{{ url('/detail/import') }}')" class="btn btn-info">Import Detail</button>
                        <a href="{{ url('/detail/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Detail</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Barang -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="barang_id" name="barang_id">
                                        <option value="">- Semua -</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Barang</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Detail Penjualan -->
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-detail">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Penjualan ID</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    function modalAction(url = '') { 
        $('#myModal').load(url, function() { 
            $('#myModal').modal('show'); 
        }); 
    }

    $(document).ready(function() {
        // Inisialisasi DataTables Penjualan
        var dataPenjualan = $('#table-penjualan').DataTable({
            serverSide: true,
            ajax: { 
                url: "{{ url('penjualan/list') }}", 
                type: "POST",
                dataType: "json",
                data: function(d) { 
                    d.user_id = $('#user_id').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "pembeli", orderable: true, searchable: true },
                { data: "penjualan_kode", orderable: true, searchable: true },
                { data: "penjualan_tanggal", orderable: true, searchable: false },
                { data: "user.nama", orderable: false, searchable: false },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        $('#user_id').on('change', function() {
            dataPenjualan.ajax.reload();
        });

        // Inisialisasi DataTables Detail Penjualan
        var tableDetail = $('#table-detail').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('/penjualan/detail/list') }}",
                type: "POST",
                dataType: "json",
                data: function(d) {
                    d.barang_id = $('#barang_id').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                { data: "penjualan_id", orderable: true, searchable: false },
                { data: "barang.barang_nama", name: 'barang.barang_nama', orderable: true, searchable: true }, // Ganti barang_id dengan nama barang
                { data: "harga", orderable: true, searchable: false },
                { data: "jumlah", orderable: true, searchable: false },
                { data: "aksi", orderable: false, searchable: false }
            ]
        });

        $('#barang_id').on('change', function() {
            tableDetail.ajax.reload();
        });
    });
</script>
@endpush
