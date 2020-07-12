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
                    <h1>Tags</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <button class="btn btn-danger btn-sm float-right" type="button" name="bulk_delete" id="bulk_delete">Delete</button>
                        <button type="button" name="create_tag" data-dismiss="modal" id="create_tag" class="btn btn-success float-right btn-sm  mr-2">Add</button>
                        <a href="{{route('tags.export')}}" class="btn btn-primary float-right btn-sm mr-2">Export</a>
                        <button name="import_tag" id="import_tag" class="btn btn-primary float-right btn-sm mr-2">Import</button>
                    </div>

                    <div class="card-body">
                        <table id="tag-table" class="table table-hover responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Tag Name</th>
                                    <th>Slug</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                    <div id="tagModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add New Tag</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="tag_form" class="form-horizontal">
                                        @csrf
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Tag Name : </label>
                                            <input type="text" name="tag" id="tag" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Tag Description : </label>
                                            <textarea name="description" id="description" class="form-control" ></textarea>
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
                                            <input type="file" name="import" id="import" class="form-control"/>
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
                                    <p>Are you sure you want to remove this Tag?</p>
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

        $('#tag-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('tags.index') }}",
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'tag',
                    name: 'tag'
                },
                {
                    data: 'slug',
                    name: 'slug'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        $('#create_tag').click(function() {
            $('.modal-title').text('Add New Tag');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#tag').val('');
            $('#description').val('');
            $('#tagModal').modal('show');
        });

        $(document).on('click', '.edit', function() {
            var tag_id = $(this).attr('id');
            $.ajax({
                url: "tags/" + tag_id + "/edit",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    $('#tag').val(data.result.tag);
                    $('#description').val(data.result.description);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit Tag');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                    $('#tagModal').modal('show');
                }
            })
        });

        $('#tag_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var method = '';
            var tag_id = '';


            if ($('#action').val() == 'Add') {
                action_url = "{{ route('tags.store') }}";
                method = "POST";
            }
            if ($('#action').val() == 'Edit') {
                tag_id = $('#hidden_id').val();
                action_url = "tags/" + tag_id;
                method = "PUT";
            }

            $.ajax({
                url: action_url,
                method: method,
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    if (data.success) {
                        toastr.success(data.success);
                        $('#tag_form')[0].reset();
                        $('#tag-table').DataTable().ajax.reload();
                        $('#tagModal').modal('hide');
                    }
                }
            })
        });

        $(document).on('click', '.delete', function() {
            tag_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
        });

        var id = [];
        $(document).on('click', '#bulk_delete', function() {
            $('.tag_checkbox:checked').each(function() {
                id.push($(this).val())
            });
            $('#confirmModal').modal('show');
            $('#ok_button').val('MassDelete');
        });

        $('#ok_button').click(function() {
            if ($('#ok_button').val() == 'Delete') {
                action_url = "tags/" + tag_id;
                method = "DELETE";
                data = tag_id;
            }

            if ($('#ok_button').val() == 'MassDelete') {
                action_url = "tags/massdelete";
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
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    if (data.success) {
                        toastr.success(data.success);
                        $('#confirmModal').modal('hide');
                        $('#tag-table').DataTable().ajax.reload();
                    }
                    $('#ok_button').text('OK');
                }
            })
        });

        $('#import_tag').click(function() {
            $('.modal-title').text('Import CSV File');
            $('#importModal').modal('show');
        });

        $('#import_form').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('tags.saveimport')}}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    if (data.success) {
                        toastr.success(data.success);
                        $('#import_form')[0].reset();
                        $('#tag-table').DataTable().ajax.reload();
                        $('#importModal').modal('hide');
                    }
                }
            });
        });
    });
</script>
@endsection