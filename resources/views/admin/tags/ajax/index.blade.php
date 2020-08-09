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

        $('#tag-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('tags.index') }}",
            },
            columns: [{
                    data: 'checkbox',
                },
                {
                    data: 'id',
                },
                {
                    data: 'tag',
                },
                {
                    data: 'slug',
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
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
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
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