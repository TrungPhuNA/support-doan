<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {!! isset($metaSeo) ? $metaSeo->renderMetaSeo() : '' !!}
        @yield('css')

        {{-- Thông báo --}}
        @if(session('toastr'))
            <script>
                var TYPE_MESSAGE = "{{session('toastr.type')}}";
                var MESSAGE = "{{session('toastr.message')}}";
            </script>
        @endif
        <script>
            var URL_BUY_TEMPORARITY = '{{ route('ajax_post.buy.temporarily') }}'
        </script>
        @include('components.load_library.onesignal')
    </head>

    <body>
        @include('components.header')
        @yield('content')
        @include('components.footer')
        @if ((request()->segment(1) !== 'tin-tuc') &&  (request()->segment(1) !== 'account'))
            @include('components.popup._inc_popup_purchase')
            @include('components.popup._inc_popup_very_account')
            @include('components.popup._inc_popup_purchase_success')
            @if (get_data_user('web','status') == -1)
                @include('components.popup._inc_popup_block_user')
            @endif
            @if (get_data_user('web') && (!get_data_user('web','phone') || !get_data_user('web','email')))
                @include('components.popup._inc_popup_alter_update_info')
            @endif
        @endif
        @include('components.popup._inc_popup_wallet')
        <script>
            var DEVICE = '{{  device_agent() }}'
        </script>
        <?php echo render_ga() ?>
        @yield('script')
    </body>

</html>
