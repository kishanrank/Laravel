@extends('layouts.app')

@section('stylesheet')
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

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" placeholder="Search Mail">
                                <div class="input-group-append">
                                    <div class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    @forelse($messages as $message)
                                    <tr>
                                        <td>
                                            <div class="icheck-primary">
                                                <input type="checkbox" value="" id="check15">
                                                <label for="check15"></label>
                                            </div>
                                        </td>
                                        <td class="mailbox-star"><a href="#"><i class="fas fa-star text-warning"></i></a></td>
                                        <td class="mailbox-name" data-id="{{ $message->id }}"><a>{{ $message->name }}</a></td>
                                        <td class="mailbox-subject" data-id="{{ $message->id }}"><b>{{ $message->subject }}</b> -
                                            {{ \Illuminate\Support\Str::limit($message->message, 30) }}
                                        </td>
                                        <td class="mailbox-attachment"><i class="fas fa-paperclip"></i></td>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="{{ asset('plugins/toastr/toastr.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('*[data-id]').on('click', function() {
            // window.location = $(this).data("href");
            var getIdFromRow = $(event.target).closest('td').data('id');
            $.ajax({
                'url': 'inbox/id/' + getIdFromRow,
                'method': 'GET',
                'success': function(data) {
                    $('#name').text(data.result.name);
                    $('#email').text(data.result.email);
                    $('#messageModalLongTitle').text(data.result.subject);
                    $('#message').text(data.result.message);
                    $('#messageModal').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            })
        });
    });
</script>
@endsection