@extends('layouts.backend.main')

@section('title','Laporan Kecelakaan | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL LAPORAN KECELAKAAN</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Dikendarai oleh : {{$kecelakaan->nama_driver}}</span>
                    </h3>
                </div>
            </div>

            @if(session()->has('success'))
            <!--begin::Alert-->
            <div
                class="alert alert-dismissible bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <!--end::Icon-->
                <!--begin::Content-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <h5 class="mb-1">Success</h5>
                    <span> {{ session()->get('success') }}</span>
                </div>
                <!--end::Content-->
                <!--begin::Close-->
                <button type="button"
                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                    data-bs-dismiss="alert">
                    <i class="bi bi-x fs-1 text-danger"></i>
                </button>
                <!--end::Close-->
            </div>
            <!--end::Alert-->
            @endif

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
                                <h2 class="fw-bolder">KECELAKAAN</h2>
                            </div>
                            <!--begin::Card title-->
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
                                                <td class="text-gray-400 min-w-175px w-175px">No. Kecelakaan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary">ACD_{{$kecelakaan->id_kecelakaan}}</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">No. Do:</td>
                                                <td class="text-gray-800">
                                                    <a
                                                        href="{{route('assign.detail',$kecelakaan->id_do)}}">DO_{{$kecelakaan->no_so}}</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tanggal Kecelakaan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($kecelakaan->tgl)->format('d-m-Y')}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Jam Kecelakaan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($kecelakaan->jam)->format('H:i')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Atasan:</td>
                                                <td class="text-gray-800">
                                                    {{$kecelakaan->atasan}}
                                                </td>
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
                                                <td class="text-gray-400">Saksi:</td>
                                                <td class="text-gray-800">
                                                    {{$kecelakaan->saksi}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Lokasi Kecelakaan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    {{$kecelakaan->lokasi}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tujuan Perjalanan:</td>
                                                <td class="text-gray-800">
                                                    {{$kecelakaan->tujuan}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Kronologi Kecelakaan:</td>
                                                <td class="text-gray-800">
                                                    {{$kecelakaan->kronologi}}
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
                            <!--begin::Section-->
                            <div class="mb-0">
                                <!--begin::Title-->
                                <h5 class="mb-4">Foto:</h5>
                                <!--end::Title-->
                                <!--begin::Card body-->
                                <div class="row g-10 row-cols-2 row-cols-lg-5">
                                    <!--begin::Col-->
                                    @foreach ($kerusakan as $kr)
                                    <div class="col text-center">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="{{url('/assets/img_accident/'.$kr->foto_pendukung)}}">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('{{url('/assets/img_accident/'.$kr->foto_pendukung)}}')">
                                            </div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="bi bi-eye-fill fs-2x text-white"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        {{$kr->keterangan}}
                                    </div>
                                    @endforeach
                                </div>
                                <!--end::Card body-->
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
                        data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{default: false}"
                        data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="true"
                        data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>KENDARAAN</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Nama Kendaraan:</td>
                                        <td class="text-gray-800">{{$kecelakaan->kendaraan}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Kode Asset:</td>
                                        <td class="text-gray-800">{{$kecelakaan->kode_asset}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">No. Pol:</td>
                                        <td class="text-gray-800">{{$kecelakaan->no_polisi}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Merk:</td>
                                        <td class="text-gray-800">{{$kecelakaan->merk}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Tipe:</td>
                                        <td class="text-gray-800">{{$kecelakaan->jenis}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Penggerak:</td>
                                        <td class="text-gray-800">{{$kecelakaan->jenis_penggerak}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Bahan Bakar:</td>
                                        <td class="text-gray-800">{{$kecelakaan->bahan_bakar}}</td>
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
