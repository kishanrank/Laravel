@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
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
                                <input type="text" class="date-from" id="date_from" name="date_from" required placeholder="MM/DD/YYYY">
                            </div>
                            <div class="form-group ml-3" id="to_date">
                                <label for="date_to">Date To: </label>
                                <input type="text" class="date-to" id="date_to" name="date_to" required placeholder="MM/DD/YYYY">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm ml-3">Export</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-header">
                        <button type="button" name="create_user" data-dismiss="modal" id="create_user" class="btn btn-success float-right btn-sm  ml-2">Add</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('users.index') }}",
        },
        columns: [{
                data: 'id',
            },
            {
                data: 'avatar',
            },
            {
                data: 'name',
            },
            {
                data: 'email',
            },
            {
                data: 'status'
            },
            {
                data: 'delete',
            }
        ]
    });

    var user_id;
    $(document).on('click', '.delete-user', function() {
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function() {
        $.ajax({
            url: "users/destroy/" + user_id,
            method: 'DELETE',
            success: function(data) {
                if (data.success) {
                    toastr.success(data.success);
                    $('#confirmModal').modal('hide');
                    $('#user-table').DataTable().ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var message = JSON.parse(jqXHR.responseText);
                toastr.error(message.error);
            }
        });
    });

    $('#create_user').click(function() {
        $('.modal-title').text('Add New User');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#name').val('');
        $('#email').val('');
        $('#password').val('');
        $('#userModal').modal('show');
    });

    $('#user_form').on('submit', function(event) {
        event.preventDefault();
        var action_url = '';
        var method = '';

        if ($('#action').val() == 'Add') {
            action_url = "{{ route('users.store') }}";
            method = "POST";
        }

        $.ajax({
            url: action_url,
            method: method,
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.success) {
                    toastr.success(data.success);
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    $('#user-table').DataTable().ajax.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var message = JSON.parse(jqXHR.responseText);
                toastr.error(message.error);
            }
        });
    });
</script>
<script>
    $(function() {
        $("#date_from").datepicker({
            maxDate: -1
        });
        $("#date_to").datepicker({
            maxDate: -1
        });
    });
</script>
@endsection