@include('admin.includes.js.ajax')
@include('admin.includes.js.datatable')
@include('admin.includes.toastr')
<!-- <script src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script> -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#posts-table thead tr').clone(true).appendTo('#posts-table thead');
        $('#posts-table tfoot tr').remove();
        $('#posts-table thead tr:eq(1) th').each(function(i) {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');

            $('input', this).on('keyup change', function() {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        var table = $('#posts-table').DataTable({
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            scrollX: true,
            ajax: {
                url: "{{ route('posts') }}",
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
                    data: 'status'
                },
                {
                    data: 'upload',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ],
            columnDefs: [{
                'searchable': false,
                'targets': [5, 6],
            }, ]
        });
    });
</script>