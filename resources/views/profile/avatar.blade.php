@extends('layouts.template')

@section('content')


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Update Avatar</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ url('/profile/avatar/store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="avatar">Pilih Avatar</label>
                            <input type="file" name="avatar" id="avatar" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Avatar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
