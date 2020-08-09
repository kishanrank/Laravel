@extends('layouts.app')

@section('stylesheet')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                            / <a href="{{ route('users.index') }}"> User</a>
                        </li>
                        <li class="breadcrumb-item">Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-4">
                <!-- Profile Image -->
                <div class="card">
                    <div class="card-header bg-primary">
                        <strong>General Information</strong>
                    </div>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="rounded-circle" src="{{ asset($admin->profile->avatar) }}" width="150px" height="150px" alt="Blog Logo">
                        </div>
                        <h3 class="profile-username text-center">{{ $admin->name }}</h3>
                        <p class="text-muted text-center">{{ $admin->email }}</p>
                        <div class="text-center">
                            <button type="button" name="update_admin_password" data-dismiss="modal" id="update_admin_password" class="btn btn-primary btn-xs  mr-2">Change Password ?</button>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div id="updateAdminPasswordModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Change Password</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="update_admin_password_form" class="form-horizontal">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Current Password :<sup class="text-danger">*</sup> </label>
                                        <input type="password" name="current_password" id="current_password" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-6">New Password : <sup class="text-danger">*</sup></label>
                                        <input type="password" name="password" id="password" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-6">Confirm Password : <sup class="text-danger">*</sup></label>
                                        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" />
                                    </div>
                            </div>
                            <br />
                            <div class="form-group text-center">
                                <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Update Password" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header bg-gray">
                        <strong>Update Profile</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $admin->name }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $admin->email }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <div class="form-group">
                                <label for="name">New Password</label>
                                <input type="text" name="password" class="form-control">
                            </div> -->

                            <div class="form-group">
                                <label for="name">Upload New Avatar</label>
                                <input type="file" name="avatar" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="name">LinkedIn Profile</label>
                                <input type="text" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" value="{{ $admin->profile->linkedin }}">
                                @error('linkedin')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Github Profile</label>
                                <input type="text" name="github" class="form-control @error('github') is-invalid @enderror" value="{{ $admin->profile->github }}">
                                @error('github')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">About You</label>
                                <textarea name="about" id="about" cols="5" rows="5" class="form-control @error('about') is-invalid @enderror">{{ $admin->profile->about }}</textarea>
                                @error('about')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="text-center">
                                    <button class="btn btn-success" type="submit">
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
@include('admin.peoples.admins.ajax.profile')
@endsection