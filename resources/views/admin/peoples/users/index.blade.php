@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@include('admin.includes.css.datatable')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">User</li>
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
                        <div class="card-group">
                            <div class="card">
                                <div class="card-body" style="background-color:lightgray">
                                    <h5 class="card-title">Total Users</h5>
                                    <h1 class="card-text">--</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body" style="background-color:lightgray">
                                    <h5 class="card-title">This Month Users</h5>
                                    <h1 class="card-text">--</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body bordered" style="background-color:lightgray">
                                    <h5 class="card-title">Active Users</h5>
                                    <h1 class="card-text">--</h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body" style="background-color:lightgray">
                                    <h5 class="card-title">User Growth</h5>
                                    <h1 class="card-text">--</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <span><b>Export User</b></span>

                        <form class="form-inline float-right" method="POST" action="{{route('users.export')}}">
                            @csrf
                            <div class="form-group" id="from_date">
                                <label for="date_from">Date From: </label>
                                <input type="text" class="date-from" id="date_from" name="date_from" required placeholder="MM/DD/YYYY" autocomplete="off">
                            </div>
                            <div class="form-group ml-3" id="to_date">
                                <label for="date_to">Date To: </label>
                                <input type="text" class="date-to" id="date_to" name="date_to" required placeholder="MM/DD/YYYY" autocomplete="off">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm ml-3"><i class="fa fa-sm fa-file-export">&nbsp;</i>Export</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-header">
                        <button type="button" name="create_user" data-dismiss="modal" id="create_user" class="btn btn-success float-right btn-sm  ml-2"><i class="fa fa-sm fa-plus">&nbsp;</i>Add</button>
                    </div>
                    <div class="card-body">
                        <table id="user-table" class="table table-hover table-bordered responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div id="userModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New User</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="user_form" class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-4">User Name : </label>
                                            <input type="text" name="name" id="name" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Email : </label>
                                            <input type="email" name="email" id="email" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Password : </label>
                                            <input type="password" name="password" id="password" class="form-control" />
                                        </div>
                                </div>
                                <br />
                                <div class="form-group text-center">
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Add Tag" />
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="confirmModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to remove this User?</p>
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
@include('admin.peoples.users.ajax.index')
@endsection