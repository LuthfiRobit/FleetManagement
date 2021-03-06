<!DOCTYPE html>

<html lang="en">
<!--begin::Head-->

<head>
    <base href="../">
    <title>Penilaian Driver</title>
    <style>
    .lis{
        display: inline-block;
        color: #F0F0F0;
        text-shadow: 0 0 1px #666666;
        font-size:30px;
    }
    .highlights, .selected {
        color:#F4B30A;
        text-shadow: 0 0 1px #F48F0A;
    }
    </style>
    @include('layouts.backend.style')
    <link href="{{url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet"
        type="text/css" />
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    {{--
    <link href="{{url('assets/backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed"
    style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" style="" class="header align-items-stretch">
                    <!--begin::Container-->
                    <div class="container-xxl d-flex align-items-stretch justify-content-between">
                        <!--begin::Aside mobile toggle-->
                        <!--end::Aside mobile toggle-->
                        <!--begin::Logo-->
                        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0 me-lg-15">
                            <a href="https://www.pomi.co.id/">
                                <img alt="Logo" src="{{url('assets/img_logo/logo_pomi1.png')}}"
                                    class="h-30px h-lg-40px" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        <!--begin::Wrapper-->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <!--begin::Navbar-->
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <!--begin::Menu wrapper-->
                                {{-- <div class="header-menu align-items-stretch">
                                    <!--begin::Menu-->
                                    <div
                                        class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch">
                                        <div class="menu-item me-lg-1">
                                            <a class="menu-link py-3" href="https://www.pomi.co.id/">
                                                <span class="menu-title">Dashboard</span>
                                            </a>
                                        </div>
                                    </div>
                                    <!--end::Menu-->
                                </div> --}}
                                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">PENILAIAN DRIVER
                                </h1>
                                <!--end::Menu wrapper-->
                            </div>
                            <!--end::Navbar-->
                            <!--begin::Topbar-->
                            {{-- top hapos --}}
                            <!--end::Topbar-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Toolbar-->

                    <!--end::Toolbar-->
                    <!--begin::Post-->
                    <div class="post d-flex flex-column-fluid" id="kt_post">
                        <!--begin::Container-->
                        <div id="kt_content_container" class="container-xxl">
                            <!--begin::Row-->
                            <div class="row gy-5 g-xl-8">
                                <!--begin::Col-->
                                <div class="col-xl-4">
                                    <!--begin::Card-->
                                    <div class="card card-flush mb-0" data-kt-sticky="true"
                                        data-kt-sticky-name="subscription-summary"
                                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                                        data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                                        data-kt-sticky-top="150px" data-kt-sticky-animation="false"
                                        data-kt-sticky-zindex="95">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>DRIVER</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 fs-6">
                                            <!--begin::Section-->
                                            <div class="mb-7">
                                                <!--begin::Details-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-60px symbol-circle me-3">
                                                        <img alt="Pic"
                                                            @if ($driver->foto_driver != null)
                                                            src="{{url('assets/img_driver/'.$driver->foto_driver)}}"
                                                            @else
                                                            src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                                            @endif  />
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Name-->
                                                        <a href="#"
                                                            class="fs-4 fw-bolder text-gray-900 text-hover-primary me-2">
                                                            {{$driver->nama_driver}}
                                                            {{-- {{$driver->nama_driver}} --}}
                                                        </a>
                                                        <!--end::Name-->
                                                        <!--begin::Email-->
                                                        <a href="#"
                                                            class="fw-bold text-gray-600 text-hover-primary">{{$driver->no_tlp}}</a>
                                                        <!--end::Email-->
                                                        <span
                                                            class="badge badge-light-primary">{{$driver->departemen}}</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Section-->
                                            <!--begin::Seperator-->
                                            <div class="separator separator-dashed mb-7"></div>
                                            <!--end::Seperator-->
                                            <!--begin::Section-->
                                            <div class="mb-10">
                                                <!--begin::Title-->
                                                <h5 class="mb-4">KENDARAAN</h5>
                                                <!--end::Title-->
                                                <!--begin::Details-->
                                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                                    <!--begin::Row-->
                                                    <tr class="">
                                                        <td class="text-gray-400">Nama:</td>
                                                        <td class="text-gray-800">{{$driver->nama_kendaraan}}</td>
                                                    </tr>
                                                    <!--end::Row-->
                                                    <!--begin::Row-->
                                                    <tr class="">
                                                        <td class="text-gray-400">No. Pol:</td>
                                                        <td class="text-gray-800">{{$driver->no_polisi}}</td>
                                                    </tr>
                                                    <!--end::Row-->
                                                </table>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-xl-8">
                                    <!--begin::Tables Widget 9-->
                                    <div class="card card-xl-stretch mb-5 mb-xl-8">
                                        <!--begin::Header-->
                                        <div class="card-header border-0 pt-5">
                                            <h3 class="card-title align-items-start flex-column">
                                                <span class="card-label fw-bolder fs-3 mb-1">KRITERIA PENILAIAN
                                                    DRIVER</span>
                                                <span class="text-muted mt-1 fw-bold fs-7">Berilah penilaian dengan
                                                    bijak, sebagai evaluasi kami terhadap pelayanan.</span>
                                            </h3>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Body-->
                                        <div class="card-body py-3">
                                            @if($find->count() > 0)
                                            <!--begin::Alert-->
                                            <div
                                                class="alert alert-dismissible bg-light-primary border-dashed d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">

                                                <!--begin::Icon-->
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                <span class="svg-icon svg-icon-5tx svg-icon-primary mb-5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10"
                                                            fill="black" />
                                                        <rect x="11" y="14" width="7" height="2" rx="1"
                                                            transform="rotate(-90 11 14)" fill="black" />
                                                        <rect x="11" y="17" width="2" height="2" rx="1"
                                                            transform="rotate(-90 11 17)" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                                <!--end::Icon-->
                                                <!--begin::Content-->
                                                <div class="text-center text-dark">
                                                    <h1 class="fw-bolder mb-5">TERIMAKASIH</h1>
                                                    <div
                                                        class="separator separator-dashed border-danger opacity-25 mb-5">
                                                    </div>
                                                    <div class="mb-9">Anda sudah melakukan penilaian driver, terimakasih
                                                        atas partisipasinya.
                                                        <br />Silahkan Kontak
                                                        <strong>082334002730</strong>
                                                        jika anda memiliki keluhan.
                                                        <br>
                                                        <a href="#" class="fw-bolder me-1">PT.POMI</strong>.
                                                    </div>
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                            <!--end::Alert-->
                                            @else
                                            <!--begin::Form-->
                                            <form id="kt_rating_form" class="form" action="{{ route("rating.store.all") }}" method="POST">
                                                @csrf
                                                <div class="table-responsive mb-10">
                                                    <!--begin::Table-->
                                                    <input type="hidden" value="{{$driver->id_do}}" name="id_do">
                                                    <input type="hidden" value="{{$responden->id_detail_so}}" name="id_so">
                                                    <input type="hidden" value="{{$responden->no_tlp}}" name="no_tlp">
                                                    <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700 demo-table"
                                                        data-kt-element="items" id="table_komponen">
                                                        <!--begin::Table head-->
                                                        <thead>
                                                            <tr
                                                                class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                                                <th class="min-w-150px w-150px">Pertanyaan</th>
                                                                <th class="min-w-100px w-150px text-end">Nilai <i
                                                                        class="bi bi-star-fill fs-1x"></i></th>
                                                                {{-- <th class="min-w-75px w-75px text-end">Action</th>
                                                                --}}
                                                            </tr>
                                                        </thead>
                                                        <!--end::Table head-->
                                                        <!--begin::Table body-->
                                                        <tbody>
                                                            @foreach ($pertanyaan as $pr)
                                                            <tr class="border-bottom border-bottom-dashed tttt"
                                                                data-kt-element="item">
                                                                <td class="pe-7">
                                                                    <span class="required">{{$pr->pertanyaan}}</span>
                                                                    <input type="hidden" value="{{$pr->id_rating}}" name="id_rating[]">
                                                                </td>
                                                                <td>
                                                                    <div class="rating" id="tutorial-{{$pr->id_rating}}">
                                                                        <input type="hidden" name="nilai[]" id="rating" class="nilai-hidden"/>
                                                                        <ul onMouseOut="resetRating({{$pr->id_rating}});">
                                                                            @for($i=1;$i<=5;$i++) 
                                                                            @php $selected = ""; @endphp
                                                                            <li class="{{$selected}} lis" 
                                                                                onmouseover="highlightStar(this,{{$pr->id_rating}});" 
                                                                                onmouseout="removeHighlight({{$pr->id_rating}});" 
                                                                                onClick="addRating(this,{{$pr->id_rating}});" >&#9733;</li>  
                                                                            @endfor
                                                                        <ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <!--end::Table body-->
                                                    </table>
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="text-center">
                                                    <button type="submit" id="kt_rating_submit" class="btn btn-primary btn-kirim" disabled>
                                                        <span class="indicator-label">Kirim</span>
                                                        <span class="indicator-progress">Mohon Tunggu...
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end:Form-->
                                            @endif
                                        </div>
                                        <!--begin::Body-->
                                    </div>
                                    <!--end::Tables Widget 9-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Post-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                @include('layouts.backend.footer')
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                    fill="black" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>
    <!--end::Scrolltop-->
    <!--end::Main-->


    <!--begin::Javascript-->
    @include('layouts.backend.script')
    <script>
        var hostUrl = "{{url('assets/backend/assets/')}}";
    </script>

    <script src="{{url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js')}}""></script>
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src=" {{url('assets/backend/assets/js/custom/documentation/documentation.js')}}"></script>
    <script src="{{url('assets/backend/assets/js/custom/documentation/search.js')}}"></script>
    <!--end::Page Custom Javascript-->
    <script text=" text/javascipt">

        function highlightStar(obj,id) {
            removeHighlight(id);		
            $('.demo-table #tutorial-'+id+' li').each(function(index) {
                $(this).addClass('highlights');
                if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
                    return false;	
                }
            });
        }

        function removeHighlight(id) {
            $('.demo-table #tutorial-'+id+' li').removeClass('selected');
            $('.demo-table #tutorial-'+id+' li').removeClass('highlights');
        }

        function addRating(obj,id) {
            $('.demo-table #tutorial-'+id+' li').each(function(index) {
                $(this).addClass('selected');
                $('#tutorial-'+id+' #rating').val((index+1));
                if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
                    return false;	
                }
            });
            // console.log($('table tr:last td input.nilai-hidden').val());
            var ok = $('table tr:last td input.nilai-hidden').val();
            if (ok == "") {
                $('.btn-kirim').prop('disabled', true);
            } else {
                $('.btn-kirim').prop('disabled', false);
            }
        }

        function resetRating(id) {
            if($('#tutorial-'+id+' #rating').val() != 0) {
                $('.demo-table #tutorial-'+id+' li').each(function(index) {
                    $(this).addClass('selected');
                    if((index+1) == $('#tutorial-'+id+' #rating').val()) {
                        return false;	
                    }
                });
            }
        } 

        // "use strict";
        // $(function () {
        //     $("input[type=radio]").on("change", function() {
        //         var val = $(this).val();
        //         var id_do = $(this).data('do');
        //         var id_rating = $(this).data('rating');
        //         var id_so = $(this).data('so');
        //         // console.log(id_do, id_rating, id_so, val);
        //         // check if radio is checked and value of checked one is `others`
        //         // ($(this).val() == "Other") ? $(this).siblings(".dvtext").show(): $(this).siblings(".dvtext").hide()
        //         $.ajax({
        //             type: 'POST',
        //             url: '{{route("rating.store")}}',
        //             data: {
        //                 '_token': '{{csrf_token()}}',
        //                 'id_do': id_do,
        //                 'id_rating':id_rating,
        //                 'id_so':id_so,
        //                 'nilai': val
        //             },
        //             datatype: 'JSON',
        //             success: function (response) {
        //                 console.log(response);
        //             },
        //             error: function (response) {
        //                 console.log(response);
        //             }
        //         });
        //     });
        // });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
