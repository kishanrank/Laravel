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
                    <h1>Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home </a>
                        </li>
                        <li class="breadcrumb-item">Posts</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <a class="btn btn-primary float-right btn-sm" href="{{ route('post.create')}}">Create New Post</a>
                    </div>
                    <div class="card-body">
                        <table id="posts-table" class="table table-striped table-bordered responsive table-condensed" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Image</th>
                                    <th width="40%">Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Publish/<br>Unpublish</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th width="40%">Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Publish/<br>Unpublish</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
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
<script type="text/javascript">
    $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('posts') }}",
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
                data: 'name',
            },
            {
                data: function(data) {
                    if (data.published == 1) {
                        return "<b>Published</b>";
                    }
                    return "<b>Not Published</b>";
                }
            },
            {
                data: 'upload'
            },
            {
                data: 'action',
            }
        ],
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var input = document.createElement("input");
                $(input).appendTo($(column.footer()).empty())
                    .on('change', function() {
                        column.search($(this).val(), false, false, true).draw();
                    });
            });
        }
    });
</script>
@include('admin.includes.toastr')
@endsection