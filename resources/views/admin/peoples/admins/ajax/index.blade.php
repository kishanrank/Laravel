@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
@include('admin.includes.toastr')
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