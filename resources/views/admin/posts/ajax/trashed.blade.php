@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
@include('admin.includes.toastr')
<script type="text/javascript">
    $(document).ready(function() {
        $('#trashed-post-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('posts.trashed') }}",
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
                    data: 'name',
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
    });
</script>