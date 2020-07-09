<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        source: function(query, result) {
            $.ajax({
                url: path,
                method: "get",
                data: {
                    query: query
                },
                dataType: "json",
                success: function(data) {
                    result($.map(data, function(data) {
                        return data.title
                    }));

                }
            });
        },
        minLength: 3
    });
</script>