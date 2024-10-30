@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body" id="detail-content">
            <!-- Data detail akan di-load secara dinamis dengan Ajax -->
            <div id="loading" style="display: none;">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="detail-table" style="display: none;">
                <tr>
                    <th>ID</th>
                    <td id="detail-id"></td>
                </tr>
                <tr>
                    <th>Kode Penjualan</th>
                    <td id="penjualan-kode"></td>
                </tr>
                <tr>
                    <th>Barang Nama</th>
                    <td id="barang-nama"></td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td id="detail-harga"></td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td id="detail-jumlah"></td>
                </tr>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        // Fungsi untuk load data detail dengan Ajax
        function loadDetail(detailId) {
            $('#loading').show();
            $('#detail-table').hide();

            $.ajax({
                url: `/detail/${detailId}/show_ajax`,  // Endpoint untuk mengambil data detail
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Isi tabel dengan data yang diterima
                        $('#detail-id').text(response.data.detail_id);
                        $('#penjualan-kode').text(response.data.penjualan_kode);
                        $('#barang-nama').text(response.data.barang_nama);
                        $('#detail-harga').text(response.data.harga);
                        $('#detail-jumlah').text(response.data.jumlah);

                        $('#detail-table').show();
                    } else {
                        alert('Data tidak ditemukan.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data.');
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        // Trigger load detail ketika modal dibuka
        $('#detailModal').on('show.bs.modal', function(e) {
            var detailId = $(e.relatedTarget).data('id');  // Ambil ID dari atribut data-id
            loadDetail(detailId);
        });
    </script>
@endpush