@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    @else
        <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div id="modal-master" class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data Penjualan Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">User</label>
                            <div class="col-11">
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">- Pilih user -</option>
                                    @foreach ($user as $item)
                                        <option {{ $item->user_id == $penjualan->user_id ? 'selected' : '' }}
                                            value="{{ $item->user_id }}">{{ $item->username }}</option>
                                    @endforeach
                                </select>
                                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Pembeli</label>
                            <input value="{{ $penjualan->pembeli }}" type="text" name="pembeli" id="pembeli" class="form-control"
                                required>
                            <small id="error-pembeli" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Kode Penjualan</label>
                            <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" placeholder="{{ $penjualan->penjualan_kode }}">
                            <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Penjualan</label>
                            <input value="{{ $penjualan->penjualan_tanggal }}" type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                                required>
                            <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function() {
                $("#form-edit").validate({
                    rules: {
                        user_id: {
                            required: true,
                            number: true
                        },
                        pembeli: {
                            required: true,
                            minlength:3
                        },
                        penjualan_kode: {
                            required: false,
                            minlength:3
                        },
                        penjualan_tanggal: {
                            required: true,
                            date:true
                        }
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    $('#myModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    });
                                    tablePenjualan.ajax.reload();
                                } else {
                                    $('.error-text').text('');
                                    $.each(response.msgField, function(prefix, val) {
                                        $('#error-' + prefix).text(val[0]);
                                    });
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Terjadi Kesalahan',
                                        text: response.message
                                    });
                                }
                            }
                        });
                        return false;
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endempty