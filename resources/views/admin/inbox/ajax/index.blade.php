@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
<script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>
@include('admin.includes.toastr')
<script>
    $(document).ready(function() {
        $('#inbox-table').DataTable({
            responsive: true,
        });
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
@include('admin.includes.toastr')