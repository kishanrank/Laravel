<script src="{{ URL::asset('plugins/toastr/toastr.min.js')}}"></script>
<script>
    $('#setting_form').on('submit', function(event) {
        event.preventDefault();

        $.ajax({
            url: "{{route('settings.update')}}",
            method: "PUT",
            data: $(this).serialize(),
            dataType: "json",
            success: function(data) {
                if (data.error) {
                    toastr.error(data.error);
                }
                if (data.success) {
                    toastr.success(data.success);
                }
            }
        })
    });
</script>