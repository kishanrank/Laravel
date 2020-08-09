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
                    <h1>Tags</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Tag</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <button class="btn btn-danger btn-sm float-right" type="button" name="bulk_delete" id="bulk_delete"><i class="fa fa-sm fa-trash">&nbsp;</i>Delete</button>
                        <button type="button" name="create_tag" data-dismiss="modal" id="create_tag" class="btn btn-success float-right btn-sm  mr-2"><i class="fa fa-sm fa-plus">&nbsp;</i>Add</button>
                        <a href="{{route('tags.export')}}" class="btn btn-primary float-right btn-sm mr-2"><i class="fa fa-sm fa-file-export">&nbsp;</i>Export</a>
                        <button name="import_tag" id="import_tag" class="btn btn-primary float-right btn-sm mr-2"><i class="fa fa-sm fa-file-import">&nbsp;</i>Import</button>
                    </div>

                    <div class="card-body">
                        <table id="tag-table" class="table table-hover table-bordered responsive" width="100%">
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
                                            <textarea name="description" id="description" class="form-control"></textarea>
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
                                            <input type="file" name="import" id="import" class="form-control" />
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
@include('admin.tags.ajax.index')
@endsection