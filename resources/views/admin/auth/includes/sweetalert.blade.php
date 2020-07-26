<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.13.1/dist/sweetalert2.all.min.js"></script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}"
    switch (type) {
        case 'success':
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{!! Session::get("message") !!}',
                showConfirmButton: true,
                timer: 5000
            })
            break;
        case 'error':
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! Session::get("message") !!}'
            })
            break;
    }
    @endif

</script>