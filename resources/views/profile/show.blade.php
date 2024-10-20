@extends('layouts.template')

@section('content')
<div class="container">
    <h1>Profile</h1>

    <div class="profile-avatar">
        <img src="{{ asset('avatars/' . $user->avatar) }}" alt="User Avatar" style="width: 150px;">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateAvatarModal">Update Avatar</button>
    </div>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Name</label>
            <input type="text" name="nama" value="{{ $user->nama }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password (optional)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update Profile</button>
    </form>

    <!-- Modal for avatar update -->
    <div class="modal fade" id="updateAvatarModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Update Avatar</h5>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="avatar" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update Avatar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
