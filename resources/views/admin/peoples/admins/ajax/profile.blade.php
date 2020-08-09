<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
@include('admin.includes.toastr')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#update_admin_password').click(function() {
            $('.modal-title').text('Change Password');
            $('#updateAdminPasswordModal').modal('show');
        });

        $('#update_admin_password_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('admin.password.update')}}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.success) {
                        toastr.success(data.success);
                        $('#update_admin_password_form')[0].reset();
                        $('#updateAdminPasswordModal').modal('hide');
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