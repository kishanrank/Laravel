@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Profile</h1>
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
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img class="rounded-circle" src="{{ asset($admin->profile->avatar) }}" width="150px" height="150px" alt="Blog Logo">
                        </div>
                        <form action="{{route('user.profile.update')}}" method="post" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label for="name">New Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>

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
@include('admin.includes.toastr')
@endsection