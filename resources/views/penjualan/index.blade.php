@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/penjualan/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i>Export Penjualan</a>
                <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="user_id" name="user_id" required>
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
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
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

    var dataPenjualan;
    $(document).ready(function() { 
        dataPenjualan = $('#table-penjualan').DataTable({
            serverSide: true,      
            ajax: { 
                "url": "{{ url('penjualan/list') }}", 
                "type": "POST", 
                "dataType": "json",
                "data": function(d) { // Send CSRF token with the request
                    d.user_id = $('#user_id').val();
                }
            }, 
            columns: [ 
                {
                    data: "DT_RowIndex",             
                    className: "text-center", 
                    orderable: false, 
                    searchable: false     
                },
                { 
                    data: "pembeli",                
                    className: "", 
                    orderable: true,     
                    searchable: true     
                },
                { 
                    data: "penjualan_kode",                
                    className: "", 
                    orderable: true,     
                    searchable: true     
                },
                { 
                    data: "penjualan_tanggal",                
                    className: "", 
                    orderable: true,     
                    searchable: false     
                },
                { 
                    data: "user.nama",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                },
                { 
                    data: "aksi",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                } 
            ] 
        }); 

        $('#user_id').on('change', function() {
            dataPenjualan.ajax.reload();
        });
    }); 
</script>
@endpush