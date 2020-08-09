@extends('layouts.app')

@section('stylesheet')
@include('admin.includes.css.datatable')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subscriber</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Subscriber</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Subscriber</h5>
                                    <h1 class="card-text">{{ $subscribers }}</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">This Month Subscriber</h5>
                                    <h1 class="card-text">{{ $subscriber30 }}</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Last Quater Subscriber</h5>
                                    <h1 class="card-text">{{ $subscriber120 }}</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Subsciber Growth</h5>
                                    <h1 class="card-text">--</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        <button class="btn btn-danger btn-sm float-right" type="button" name="bulk_delete" id="bulk_delete"><i class="fa fa-sm fa-trash">&nbsp;</i>Delete</button>
                        <a href="{{route('subscribers.export')}}" class="btn btn-primary float-right btn-sm mr-2"><i class="fa fa-sm fa-file-export">&nbsp;</i>Export</a>
                    </div>

                    <div class="card-body">
                        <table id="subscriber-table" class="table table-striped table-bordered responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div id="confirmModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to remove this Subscriber?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('script')
@include('admin.subscribers.ajax.index')
@endsection