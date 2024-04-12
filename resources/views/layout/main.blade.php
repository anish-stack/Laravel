<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    @include('layout.head')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body"
    class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->

        <!--begin::mobile header-->
        @include('layout.head_mobile');
        <!--end::mobile header-->

        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">

                <!--begin::Aside-->
                @include('layout.sidebar');
                <!--end::Aside-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->
                    @include('layout.header');
                    <!--begin::Header-->

                    @yield('main-container');

                     <!--begin::pop-->
                    @include('layout.popdata');
                    <!--end::pop-->
                    
                    <!--begin::Footer-->
                    @include('layout.footer');
                    <!--end::Footer-->

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
    <!--end::Main-->
    
</body>

</html>
