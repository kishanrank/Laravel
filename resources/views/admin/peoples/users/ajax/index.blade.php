@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
@include('admin.includes.toastr')
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
                searchable: false,
                orderable: false
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