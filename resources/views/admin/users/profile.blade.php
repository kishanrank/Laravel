@extends('layouts.app')


@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Profile</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.profile.update')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
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
                                <label for="name">Facebook Profile</label>
                                <input type="text" name="facebook" class="form-control @error('facebook') is-invalid @enderror" value="{{ $user->profile->facebook }}">
                                @error('facebook')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Youtube Profile</label>
                                <input type="text" name="youtube" class="form-control @error('youtube') is-invalid @enderror" value="{{ $user->profile->youtube }}">
                                @error('youtube')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">About You</label>
                                <textarea name="about" id="about" cols="5" rows="5" class="form-control @error('about') is-invalid @enderror">{{ $user->profile->about }}</textarea>
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
