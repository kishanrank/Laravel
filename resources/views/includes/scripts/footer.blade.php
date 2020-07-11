<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#subscribe_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{route('subscribe')}}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.message) {
                        $('#subscribe-message').addClass("text-dark")
                        $('#subscribe-message').text(data.message);
                    }
                    $('#email').val('');
                }
            });
        });
    });
</script>