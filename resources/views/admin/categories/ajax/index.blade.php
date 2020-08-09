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

        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('categories.index') }}",
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
                    data: 'name',
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

        $('#create_category').click(function() {
            $('.modal-title').text('Add New Category');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#name').val('');
            $('#description').val('');
            $('#categoryModal').modal('show');
        });

        $('#category_form').on('submit', function(event) {
            event.preventDefault();
            var action_url = '';
            var method = '';

            if ($('#action').val() == 'Add') {
                action_url = "{{ route('categories.store') }}";
                method = "POST";
            }

            if ($('#action').val() == 'Edit') {
                category_id = $('#hidden_id').val();
                action_url = "categories/" + category_id;
                method = "PUT";
            }

            $.ajax({
                url: action_url,
                method: method,
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    if (data.success) {
                        toastr.success(data.success);
                        $('#category_form')[0].reset();
                        $('#category-table').DataTable().ajax.reload();
                        $('#categoryModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            })
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "categories/" + id + "/edit",
                dataType: "json",
                success: function(data) {
                    if (data.error) {
                        toastr.error(data.error)
                    }
                    $('#name').val(data.result.name);
                    $('#description').val(data.result.description);
                    $('#hidden_id').val(data.result.id);
                    $('.modal-title').text('Edit Category');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
                    $('#categoryModal').modal('show');
                }
            })
        });
        var category_id;

        $(document).on('click', '.delete', function() {
            category_id = $(this).attr('id');
            $('#confirmModal').modal('show');
            $('.modal-title').text('Confirmation!');
            $('#ok_button').val('Delete');
            $('#ok_button').text('OK');
        });

        var id = [];
        $(document).on('click', '#bulk_delete', function() {
            $('.category_checkbox:checked').each(function() {
                id.push($(this).val())
            });
            $('#confirmModal').modal('show');
            $('#ok_button').val('MassDelete');
            $('#ok_button').text('OK');
        });

        $('#ok_button').click(function() {
            if ($('#ok_button').val() == 'Delete') {
                action_url = "categories/" + category_id;
                method = "DELETE";
                data = category_id;
            }

            if ($('#ok_button').val() == 'MassDelete') {
                action_url = "categories/massdelete";
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
                        $('#category-table').DataTable().ajax.reload();
                        $('#confirmModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                    $('#confirmModal').modal('hide');
                }
            })
        });

        $('#import_category').click(function() {
            $('.modal-title').text('Import CSV File');
            $('#importModal').modal('show');
        });

        $('#import_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('categories.saveimport')}}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#import_form')[0].reset();
                        $('#category-table').DataTable().ajax.reload();
                        $('#importModal').modal('hide');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    var message = JSON.parse(jqXHR.responseText);
                    toastr.error(message.error);
                }
            });
        });
    });
</script>