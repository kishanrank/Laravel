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

        $('#news-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('news.index') }}",
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
                    data: function(data) {
                        if (data.published == 1) {
                            return "Published";
                        }
                        return "Un Published"
                    }
                },
                {
                    data: 'upload'
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                },

            ]
        });
    });
</script>