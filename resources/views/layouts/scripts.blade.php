    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <!-- Libs JS -->
    {{-- <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script> --}}
    <!-- Tabler Core -->
    <script src="{{ asset('admin/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('admin/js/demo.min.js') }}" defer></script>
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            var type = "{{ Session::get('type') }}";
            var message = "{{ Session::get('message') }}";
            toastr[type](message);
        </script>
    @endif
    <script>
        window.addEventListener('alert', ({
            detail: {
                type,
                message
            }
        }) => {
            toastr[type](message);
        })
    </script>
    <script>
        $('textarea').keyup(function() {
            $(this).prev().find('.current_count').text($(this).val().length);
        });
    </script>
    @stack('scripts')
    @livewireScripts
