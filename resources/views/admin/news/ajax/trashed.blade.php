@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
@include('admin.includes.toastr')
<script type="text/javascript">
    $('#trashed-news-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('news.trashed') }}",
        },
        columns: [{
                data: 'id',
            },
            {
                data: 'featured',
            },
            {
                data: 'title',
            },
            {
                data: 'restore',
                searchable: false,
                orderable: false
            },
            {
                data: 'delete',
                searchable: false,
                orderable: false
            }
        ]
    });
</script>