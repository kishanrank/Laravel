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
                    <h1>Inbox</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">Inbox</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Inbox</h3>

                        <!-- <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive mailbox-messages">
                            <table id="inbox-table" class="table table-hover responsive table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($messages as $message)
                                    <tr>
                                        <td class="mailbox-name" data-id="{{ $message->id }}"><a>{{ $message->name }}</a></td>
                                        <td class="mailbox-subject" data-id="{{ $message->id }}"><b>{{ $message->subject }}</b> -
                                            {{ \Illuminate\Support\Str::limit($message->message, 30) }}
                                        </td>
                                        <!-- <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td> -->
                                        <td class="mailbox-date">{{$message->created_at->toFormattedDateString()}}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center"> Sorry, No messages available right now.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="messageModalLongTitle"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <h4>Name</h4>
                                    <p id="name"></p>
                                    <hr>
                                    <h5>Email</h5>
                                    <p id="email"></p>
                                    <hr>
                                    <h5>Message</h5>
                                    <p id="message"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>
@endsection
@section('script')
@include('admin.inbox.ajax.index')
@endsection