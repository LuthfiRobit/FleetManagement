@extends('layouts.backend.main')

@section('title','Status Driver | Detail')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL STATUS DRIVER</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Driver : {{$status->nama_driver}}</span>
                    </h3>
                </div>
            </div>
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">STATUS DRIVER</h2>
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                @if ($status->status == 'r')
                                <div class=" bg-light-primary rounded border-primary border border-dashed p-2">
                                    AKTIF
                                </div>
                                @elseif ($status->status == 'n')
                                <div class=" bg-light-warning rounded border-warning border border-dashed p-2">
                                    NON AKTIF
                                </div>
                                @endif
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Tanggal Non Aktif:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    {{Carbon\Carbon::parse($status->tgl_nonaktif)->format('d F Y')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Tanggal Aktif:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($status->tgl_aktif != null)
                                                    {{Carbon\Carbon::parse($status->tgl_aktif)->format('d F Y')}}
                                                    @else
                                                    ---
                                                    @endif

                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Lama Non Aktif:</td>
                                                <td class="text-gray-800">
                                                    @if ($status->jml_nonaktif != null)
                                                    {{$status->jml_nonaktif}}
                                                    @else
                                                    ---
                                                    @endif

                                                    Hari</td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Status:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($status->status == 'r')
                                                    <div class="badge badge-lg badge-light-primary d-inline">
                                                        AKTIF
                                                    </div>
                                                    @elseif ($status->status == 'n')
                                                    <div class=" badge badge-lg badge-light-warning d-inline">
                                                        NON AKTIF
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Keterangan:</td>
                                                <td class="text-gray-800">{{$status->keterangan}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Bukti:</td>
                                                <td class="text-gray-800">
                                                    <div
                                                        class="col text-center bg-light-primary rounded border-primary border border-dashed">
                                                        <!--begin::Overlay-->
                                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                            href="{{url('/assets/img_bukti/'.$status->foto_bukti)}}">
                                                            <!--begin::Image-->
                                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                                style="background-image:url('{{url('/assets/img_bukti/'.$status->foto_bukti)}}')">
                                                            </div>
                                                            <!--end::Image-->
                                                            <!--begin::Action-->
                                                            <div
                                                                class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                                <i class="bi bi-eye-fill fs-2x text-white"></i>
                                                            </div>
                                                            <!--end::Action-->
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>DRIVER</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div
                                        class="symbol symbol-60px symbol-circle me-3 border-primary border border-dashed">
                                        <img alt="Pic" @if ($status->foto_driver != null)
                                        src="{{url('assets/img_driver/'.$status->foto_driver)}}"
                                        @else
                                        src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                        @endif
                                        />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-2">
                                            {{$status->nama_driver}}
                                        </a>
                                        <!--end::Name-->
                                        <!--begin::Email-->
                                        <a href="#"
                                            class="fw-bold text-gray-600 text-hover-primary">{{$status->no_tlp}}</a>
                                        <!--end::Email-->
                                        <span class="badge badge-light-primary">{{$status->departemen}}</span>
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
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-400">History Non Aktif:</td>
                                    <td class="text-gray-800">{{$history}} hari</td>
                                </tr>
                            </table>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";
</script>
@endpush
