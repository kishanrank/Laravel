@extends('layouts.app')

@section('stylesheet')
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-danger btn-sm float-right" type="button" name="bulk_delete" id="bulk_delete">Delete</button>
                        <button type="button" name="create_category" data-dismiss="modal" id="create_category" class="btn btn-success float-right btn-sm  mr-2">Add</button>
                        <button name="import_category" id="import_category" class="btn btn-success float-right btn-sm mr-2">Import</button>
                        <a href="{{route('categories.export')}}" class="btn btn-primary float-right btn-sm mr-2">Export</a>
                    </div>

                    <div class="card-body">
                        <table id="category-table" class="table table-hover table-bordered responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <div id="categoryModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Category</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="category_form" class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Category Name : </label>
                                            <input type="text" name="name" id="name" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-6">Category Description : </label>
                                            <textarea name="description" id="description" class="form-control"></textarea>
                                        </div>
                                </div>
                                <br />
                                <div class="form-group text-center">
                                    <input type="hidden" name="action" id="action" value="Add" />
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                                    <input type="submit" name="action_button" id="action_button" class="btn btn-primary" value="Add Category" />
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="importModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Import CSV File</h3>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="import_form" class="form-horizontal" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Choose File : </label>
                                            <input type="file" name="import" id="import" class="form-control" required />
                                            <div>*Only CSV files are allowed to upload.</div>
                                        </div>
                                </div>
                                <br>
                                <div class="form-group text-center">
                                    <input type="submit" name="import_button" id="import_button" class="btn btn-primary" value="Upload" />
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
                                    <p>Are you sure you want to remove this Category?</p>
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
@include('admin.includes.toastr')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('categories.index') }}",
            },
            columns: [{
                    data: 'checkbox',
                },
                {
                    data: 'id',
                },
                {
                    data: 'name',
                },
                {
                    data: 'slug',
                },
                {
                    data: 'action',
                }
            ]
        });

        $('#create_category').click(function() {
            $('.modal-title').text('Add New Category');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#name').val('');
            $('#description').val('');
            $('#categoryModal').modal('show');
        });

        $('#category_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var method = '';

            if ($('#action').val() == 'Add') {
                action_url = "{{ route('categories.store') }}";
                method = "POST";
            }

            if ($('#action').val() == 'Edit') {
                category_id = $('#hidden_id').val();
                action_url = "categories/" + category_id;
                method = "PUT";
            }

            $.ajax({
                url: action_url,
                method: method,
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    if (data.success) {
                        toastr.success(data.success);
                        $('#category_form')[0].reset();
                        $('#category-table').DataTable().ajax.reload();
                        $('#categoryModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "categories/" + id + "/edit",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    $('#name').val(data.result.name);
                    $('#description').val(data.result.description);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit Category');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                    $('#categoryModal').modal('show');
                }
            })
        });
        var category_id;

        $(document).on('click', '.delete', function() {
            category_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
            $('#ok_button').text('OK');
        });

        var id = [];
        $(document).on('click', '#bulk_delete', function() {
            $('.category_checkbox:checked').each(function() {
                id.push($(this).val())
            });
            $('#confirmModal').modal('show');
            $('#ok_button').val('MassDelete');
            $('#ok_button').text('OK');
        });

        $('#ok_button').click(function() {
            if ($('#ok_button').val() == 'Delete') {
                action_url = "categories/" + category_id;
                method = "DELETE";
                data = category_id;
            }

            if ($('#ok_button').val() == 'MassDelete') {
                action_url = "categories/massdelete";
                method = "POST";
                data = {
                    id: id
                };
            }

            $.ajax({
                url: action_url,
                method: method,
                data: data,
                beforeSend: function() {
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#category-table').DataTable().ajax.reload();
                        $('#confirmModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                    $('#confirmModal').modal('hide');
                }
            })
        });

        $('#import_category').click(function() {
            $('.modal-title').text('Import CSV File');
            $('#importModal').modal('show');
        });

        $('#import_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('categories.saveimport')}}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#import_form')[0].reset();
                        $('#category-table').DataTable().ajax.reload();
                        $('#importModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            });
        });
    });
</script>
@endsection