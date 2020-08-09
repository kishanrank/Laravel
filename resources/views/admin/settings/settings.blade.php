@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Setting</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Setting</li>
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

                        @if($settings)
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset($settings->site_logo) }}" alt="Blog Logo">
                        </div>
                        <form method="post" id="setting_form">
                            {{ csrf_field() }}
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Site Name</label>
                                <input type="text" name="site_name" class="form-control" value="{{ $settings->site_name }}">

                            </div>

                            <div class="form-group">
                                <label for="name">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ $settings->address }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control" value="{{ $settings->contact_number }}">
                            </div>

                            <div class="form-group">
                                <label for="name">Contact Email</label>
                                <input type="text" name="contact_email" class="form-control" value="{{ $settings->contact_email }}">
                            </div>

                            <div class="form-group">
                                <div class="text-center">
                                    <button class="btn btn-success" type="submit">
                                        Update Setting
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="text-center">
                            <strong>No settings found right now, Please try after sometime.</strong>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
@include('admin.settings.ajax.settings')
@endsection