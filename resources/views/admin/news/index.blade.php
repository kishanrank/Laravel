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
                    <h1>News</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header font-weight-bold">
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('news.create')}}">Create New News</a>
                    </div>
                    <div class="card-body">
                        <table id="news-table" class="table table-striped responsive" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Featured</th>
                                    <th>Title</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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

        $('#news-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('news.index') }}",
            },
            columns: [{
                    data: 'id',
                },
                {
                    data: 'featured',
                },
                {
                    data: 'title',
                },
                {
                    data: 'edit',
                },
                {
                    data: 'delete'
                }
            ]
        });

        $('#create_news').click(function() {
            $('.modal-title').text('Add News');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#title').val('');
            $('#info').val('');
            $('#content').val('');
            $('#newsModal').modal('show');
        });

        $('#news_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var method = '';
            var data = '';
            if ($('#action').val() == 'Add') {
                action_url = "{{ route('news.store') }}";
                var form = $('#news_form')[0];
                data = new FormData(form);
            }

            if ($('#action').val() == 'Edit') {
                news_id = $('#hidden_id').val();
                action_url = "news/" + news_id;
                var data = new FormData($(this)[0]);
                data.append('_method', 'PUT');
            }

            $.ajax({
                url: action_url,
                enctype: 'multipart/form-data',
                method: "POST",
                data: data,
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
                        $('#news-table').DataTable().ajax.reload();
                        $('#newsModal').modal('hide');
                    }
                    $('#news_form')[0].reset();
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "news/" + id + "/edit",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    $('#title').val(data.result.title);
                    $('#info').val(data.result.info);
                    $('#content').val(data.result.info);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit News');
                    $('#action_button').val('Edit');
                    $('#action').val('Edit');
                    $('#newsModal').modal('show');
                }
            })
        });

        var news_id;
        $(document).on('click', '.delete', function() {
            news_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
        });

        $('#ok_button').click(function() {
            if ($('#ok_button').val() == 'Delete') {
                action_url = "news/" + news_id;
                method = "DELETE";
                data = news_id;
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
                        $('#news-table').DataTable().ajax.reload();
                    }
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('OK');
                }
            })
        });

    });
</script>

@endsection