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

        $('#subscriber-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('subscribers.index') }}",
            },
            columns: [{
                    data: 'checkbox',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id',
                },
                {
                    data: 'email',
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ]
        });

        $(document).on('click', '.delete', function() {
            subscriber_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
        });

        var id = [];
        $(document).on('click', '#bulk_delete', function() {
            $('.subscriber_checkbox:checked').each(function() {
                id.push($(this).val())
            });
            $('#confirmModal').modal('show');
            $('#ok_button').val('MassDelete');
        });

        $('#ok_button').click(function() {
            if ($('#ok_button').val() == 'Delete') {
                action_url = "subscribers/" + subscriber_id;
                method = "DELETE";
                data = subscriber_id;
            }

            if ($('#ok_button').val() == 'MassDelete') {
                action_url = "subscribers/massdelete";
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
                        $('#subscriber-table').DataTable().ajax.reload();
                    }
                    if (data.error) {
                        toastr.error(data.error);
                    }
                    $('#confirmModal').modal('hide');
                    $('#ok_button').text('OK');
                }
            })
        });
    });
</script>