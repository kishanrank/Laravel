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
                    <h1>Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Admin</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button type="button" name="create_admin" data-dismiss="modal" id="create_admin" class="btn btn-success float-right btn-sm  ml-2">Add</button>
                    </div>
                    <div class="card-body">
                        <table id="admin-table" class="table table-hover table-bordered responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div id="adminModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Admin</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="admin_form" class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Name : </label>
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
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Add Admin" />
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
                                    <p>Are you sure you want to remove this Admin?</p>
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
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#admin-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('admins.index') }}",
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
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });

        $('#create_admin').click(function() {
            $('.modal-title').text('Add New Admin');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#adminModal').modal('show');
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "admins/" + id + "/edit",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    $('#name').val(data.result.name);
                    $('#email').val(data.result.email);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit Admin');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                    $('#adminModal').modal('show');
                }
            })
        });

        $('#admin_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var method = '';

            if ($('#action').val() == 'Add') {
                action_url = "{{ route('admins.store') }}";
                method = "POST";
            }

            if ($('#action').val() == 'Edit') {
                admin_id = $('#hidden_id').val();
                action_url = "admins/" + admin_id;
                method = "PUT";
            }

            $.ajax({
                url: action_url,
                method: method,
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#admin_form')[0].reset();
                        $('#adminModal').modal('hide');
                        $('#admin-table').DataTable().ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            });
        });

        var admin_id;
        $(document).on('click', '.delete', function() {
            admin_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
            $('#ok_button').text('OK');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "admins/" + admin_id,
                method: 'DELETE',
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#confirmModal').modal('hide');
                        $('#admin-table').DataTable().ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                    $('#confirmModal').modal('hide');
                }
            });
        });
    });
</script>
@endsection