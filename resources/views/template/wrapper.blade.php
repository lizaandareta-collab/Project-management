<!DOCTYPE html>
<html lang="zxx" class="js">
@include('template.head')

<body class="nk-body ui-rounder npc-default has-sidebar">

    <div class="nk-app-root">
        @include('template.header')
        @include('template.navbar')

        <!-- Main Content -->
        <div class="nk-main">
            <div class="nk-wrap">

                <!-- Content Area -->
                <div class="nk-content" style="flex: 1; padding-top: 80px;">
                    <div class="container-fluid h-100">
                        <div class="nk-content-inner h-100">
                            <div class="nk-content-body h-100">
                                
                                @if(isset($content))
                                    @include($content)
                                @else
                                    @yield('content')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Content Area -->

                @include('template.footer')
            </div>
        </div>

        @include('template.alert')
    </div>

    @include('template.js')
</body>

</html>