@extends('layouts.backend.main')

@section('title','Laporan Perbaikan | Detail')
@section('style-on-this-page-only')
<link href="{{url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Invoice 2 main-->
            <div class="card">
                <!--begin::Body-->
                <div class="card-body p-lg-20">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-xl-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <!--begin::Invoice 2 content-->
                            <div class="mt-n1">
                                <!--begin::Top-->
                                <div class="d-flex flex-stack pb-10">
                                    <!--begin::Logo-->
                                    <a href="https://www.pomi.co.id/">
                                        <img alt="Logo" src="{{url('assets/img_logo/logo_pomi1.png')}}"
                                            class="h-75px w-200px logo" />
                                    </a>
                                    <!--end::Logo-->
                                    <!--begin::Action-->
                                    <span class="fw-bolder fs-3 text-gray-800 mb-8">
                                        Invoice WO_{{$perbaikan->no_wo}}
                                    </span>
                                    <!--end::Action-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    {{-- <div class="fw-bolder fs-3 text-gray-800 mb-8">Invoice #34782</div> --}}
                                    <!--end::Label-->
                                    <!--begin::Row-->
                                    <div class="row g-5 mb-11">
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">Tgl. Penyelesaian:</div>
                                            <!--end::Label-->
                                            <!--end::Col-->
                                            <div class="fw-bolder fs-6 text-gray-800">
                                                {{\Carbon\Carbon::parse($perbaikan->tgl_selesai)->format('d, M Y')}}
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">Tgl. Selesai:</div>
                                            <!--end::Label-->
                                            <!--end::Info-->
                                            <div
                                                class="fw-bolder fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                <span class="pe-2">
                                                    {{\Carbon\Carbon::parse($perbaikan->tgl_penyelesaian)->format('d, M
                                                    Y')}}</span>
                                                @if(\Carbon\Carbon::parse($perbaikan->tgl_penyelesaian)->greaterThan(\Carbon\Carbon::parse($perbaikan->tgl_selesai)))
                                                <span class="fs-7 text-danger d-flex align-items-center">
                                                    <span class="bullet bullet-dot bg-danger me-2"></span>Penalti
                                                    {{ \Carbon\Carbon::parse( $perbaikan->tgl_penyelesaian
                                                    )->diffInDays( $perbaikan->tgl_selesai) }}
                                                    Hari</span>
                                                @endif
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="row g-5 mb-3">
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">Komponen:</div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Content-->
                                    <div class="flex-grow-1">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                        <th class="min-w-175px pb-2">Komponen</th>
                                                        <th class="min-w-70px text-end pb-2">Jumlah</th>
                                                        <th class="min-w-80px text-end pb-2">Harga</th>
                                                        <th class="min-w-100px text-end pb-2">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($detail_perbaikan as $dp)
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                                        <td class="d-flex align-items-center pt-6">
                                                            <i class="fa fa-genderless text-danger fs-2 me-2"></i>
                                                            {{$dp->nama_komponen}}
                                                        </td>
                                                        <td class="pt-6">{{$dp->jml_komponen}}</td>
                                                        <td class="pt-6">Rp. {{$dp->harga_satuan}}</td>
                                                        <td class="pt-6 text-dark fw-boldest">Rp. {{$dp->jml_komponen *
                                                            $dp->harga_satuan}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        <!--begin::Container-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Section-->
                                            <div class="mw-300px">
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountname-->
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">Total:</div>
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    <div class="text-end fw-bolder fs-6 text-gray-800">Rp.
                                                        {{$perbaikan->total}}</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Container-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Invoice 2 content-->
                        </div>
                        <!--end::Content-->
                        <!--begin::Sidebar-->
                        <div class="m-0">
                            <!--begin::Invoice 2 sidebar-->
                            <div
                                class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">
                                <!--begin::Labels-->
                                <div class="mb-8">
                                    <span class="badge badge-light-primary me-2">Selesai</span>
                                    @if ($perbaikan->status_penyelesaian == 'o')
                                    <span class="badge badge-light-success">Tepat Waktu</span>
                                    @else
                                    <span class="badge badge-light-danger">Penalti</span>
                                    @endif
                                </div>
                                <!--end::Labels-->
                                <!--begin::Title-->
                                <h6 class="mb-8 fw-boldest text-gray-600 text-hover-primary">DETAIL KENDARAAN</h6>
                                <!--end::Title-->
                                <!--begin::Item-->
                                <div class="mb-6">
                                    <div class="fw-bold text-gray-600 fs-7">Kendaraan:</div>
                                    <div class="fw-bolder fs-6 text-gray-800">
                                        {{$perbaikan->nama_kendaraan}} | <a href="#"
                                            class="link-primary ps-1">{{$perbaikan->no_polisi}}</a>
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="mb-6">
                                    <div class="fw-bold text-gray-600 fs-7">Kilometer/pengecekan:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->km_kendaraan}} Km.</div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Title-->
                                <h6 class="mb-8 fw-boldest text-gray-600 text-hover-primary">DETAIL DEALER</h6>
                                <!--end::Title-->
                                <!--begin::Item-->
                                <div class="mb-6">
                                    <div class="fw-bold text-gray-600 fs-7">Dealer:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->nama_dealer}} |
                                        @if ($perbaikan->status_dealer == 'p')
                                        <span class="badge badge-light-primary">Perusahaan</span>
                                        @else
                                        <span class="badge badge-light-warning">Partner</span>
                                        @endif
                                    </div>
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="mb-6">
                                    <div class="fw-bold text-gray-600 fs-7">Alamat:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->alamat}}
                                    </div>
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Invoice 2 sidebar-->
                        </div>
                        <!--end::Sidebar-->
                    </div>
                    <!--end::Layout-->
                </div>
                <!--end::Body-->
            </div>
            <!--end::Invoice 2 main-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}">
</script>
<!--end::Page Vendors Javascript-->
<script text="text/javascipt">
    "use strict";
</script>
@endpush
