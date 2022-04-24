@extends('layouts.backend.main')

@section('title','Dashboard | Main Dashboard')
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
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Mixed Widget 2-->
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header border-0 bg-danger py-5">
                            <h3 class="card-title fw-bolder text-white">Informasi Umum</h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <button type="button"
                                    class="btn btn-sm btn-icon btn-color-white btn-active-white btn-active-color- border-0 me-n3 active"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <i class="bi bi-nut-fill fs-2x"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body p-0">
                            <!--begin::Chart-->
                            <div class=" card-rounded-bottom bg-danger" data-kt-color="danger" style="height: 200px">
                            </div>
                            <!--end::Chart-->
                            <!--begin::Stats-->
                            <div class="card-p mt-n20 position-relative">
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col bg-light-warning px-6 py-8 rounded-2 me-7 mb-7"
                                        onclick="location.href='{{ route('dashboard.kendaraan.main.index') }}'"
                                        style="cursor:pointer">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-warning d-block my-2">
                                            <i class="fa fa-car fs-3x text-warning"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <a href="{{ route('dashboard.kendaraan.main.index') }}"
                                            class="text-warning fw-bold fs-6">{{$kendaraan}} Mobil</a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-primary px-6 py-8 rounded-2 mb-7"
                                        onclick="location.href='{{ route('dashboard.driver.index') }}'"
                                        style="cursor:pointer">
                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-primary d-block my-2">
                                            <i class="bi bi-person-badge fs-3x text-primary"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <a href="{{ route('dashboard.driver.index') }}"
                                            class="text-primary fw-bold fs-6">{{$driver}} Driver</a>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row g-0">
                                    <!--begin::Col-->
                                    <div class="col bg-light-danger px-6 py-8 rounded-2 me-7"
                                        onclick="location.href='{{ route('assign.main') }}'" style="cursor:pointer">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <i class="bi bi-pin-map-fill fs-3x text-danger"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <a href="{{ route('assign.main') }}"
                                            class="text-danger fw-bold fs-6 mt-2">{{$penugasan->count()}}
                                            Perjalanan</a>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col bg-light-success px-6 py-8 rounded-2"
                                        onclick="location.href='{{ route('repair.main') }}'" style="cursor:pointer">
                                        <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                        <span class="svg-icon svg-icon-3x svg-icon-success d-block my-2">
                                            <i class="fa fa-wrench fs-3x text-success"></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <a href="{{ route('repair.main') }}"
                                            class="text-success fw-bold fs-6 mt-2">{{$perbaikan->count()}}
                                            Perbaikan</a>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 2-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::List Widget 5-->
                    <div class="card card-xl-stretch">
                        <!--begin::Header-->
                        <div class="card-header align-items-center border-0 mt-4">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="fw-bolder mb-2 text-dark">Driver dalam penugasan</span>
                                <span class="text-muted fw-bold fs-7">{{$penugasan->count()}} driver</span>
                            </h3>
                            <div class="card-toolbar">
                                <!--begin::Menu-->
                                <a href="{{ route('assign.main') }}" type="button"
                                    class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary active"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <i class="fa fa-car fs-2x "></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--end::Menu-->
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-5">
                            <!--begin::Timeline-->
                            <div class="timeline-label">
                                @forelse ($penugasan as $pg)

                                <!--begin::Item-->
                                <div class="timeline-item">
                                    <!--begin::Label-->
                                    <div class="timeline-label fw-bolder text-gray-800 fs-6px">
                                        <span class="svg-icon svg-icon-3x svg-icon-danger d-block my-2">
                                            <i class="bi bi-pin-map-fill fs-1 text-danger"></i>
                                        </span>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Badge-->
                                    <div class="timeline-badge ">
                                        <i class="fa fa-genderless text-warning fs-1"></i>
                                    </div>
                                    <!--end::Badge-->
                                    <!--begin::Text-->
                                    <div class="fw-mormal timeline-content text-muted ps-3">
                                        <span class="text-dark bold">{{$pg->nama_driver}}</span> <br>
                                        Ke : {{$pg->tujuan}}
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--end::Item-->
                                @empty
                                <div
                                    class="bg-light-primary rounded border-primary border border-dashed p-2 text-center">
                                    <h3 class="mb-1">Belum Ada Perjalanan
                                    </h3>
                                </div>
                                @endforelse
                            </div>
                            <!--end::Timeline-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end: List Widget 5-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Mixed Widget 7-->
                    <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <!--begin::Stats-->
                            <div class="flex-grow-1 card-p pb-0">
                                <div class="d-flex flex-stack flex-wrap">
                                    <div class="me-2">
                                        <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Status
                                            Driver</a>
                                        <div class="text-muted fs-7 fw-bold">{{$status->count()}} driver nonaktif</div>
                                    </div>
                                    <div class="card-toolbar">
                                        <!--begin::Menu-->
                                        <a href="{{ route('status.main') }}" type="button"
                                            class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary active"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-person-badge fs-2x "></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--end::Menu-->
                                    </div>
                                </div>
                                <!--begin::Table container-->
                                <table
                                    class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                            <th>No. Badge</th>
                                            <th>Nama</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($status as $st)
                                        <tr>
                                            <td>{{$st->no_badge}}</td>
                                            <td>{{$st->nama_driver}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2">Tidak Ada Data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!--end::Table container-->
                            </div>
                            <!--end::Stats-->

                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 7-->
                    <!--begin::Mixed Widget 10-->
                    <div class="card card-xxl-stretch-50 mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
                            <!--begin::Hidden-->
                            <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-9 pb-3">
                                <div class="me-2">
                                    <span class="fw-bolder text-gray-800 d-block fs-3">Kendaraan Diperbaiki</span>
                                    <span class="text-gray-400 fw-bold">{{$perbaikan->count()}} dalam perbaikan</span>
                                </div>
                                <div class="card-toolbar">
                                    <!--begin::Menu-->
                                    <a href="{{ route('repair.main') }}" type="button"
                                        class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary active"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                        <span class="svg-icon svg-icon-2">
                                            <i class="fa fa-wrench fs-2x "></i>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </a>
                                    <!--end::Menu-->
                                </div>
                                <!--begin::Table container-->
                                <table
                                    class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                            <th>No. Polisi</th>
                                            <th>Nama Kendaraan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($perbaikan as $pr)
                                        <tr>
                                            <td>{{$pr->no_polisi}}</td>
                                            <td>{{$pr->nama_kendaraan}}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak Ada Data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <!--end::Table container-->
                            </div>
                            <!--end::Hidden-->
                        </div>
                    </div>
                    <!--end::Mixed Widget 10-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Row-->
            <div class="row gy-5 g-xl-8">
                <!--begin::Col-->
                <div class="col-xl-12">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xl-stretch mb-5 mb-xl-12">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">History driver rating tertinggi</span>
                                {{-- <span class="text-muted mt-1 fw-bold fs-7">5 driver aktif</span> --}}
                            </h3>
                            <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top">
                                <a href="{{ route('rating.main') }}" type="button"
                                    class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary active"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <i class="fa fa-book fs-2x "></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted">
                                            <th class="min-w-50px">No. Badge</th>
                                            <th class="min-w-140px">Nama</th>
                                            <th class="min-w-100px">Penugasan</th>
                                            <th class="min-w-100px">Penugasan dibatalkan</th>
                                            <th class="min-w-100px">Jumlah Nonaktif</th>
                                            <th class="min-w-100px">Kecelakaan</th>
                                            <th class="min-w-120px">Rating</th>
                                        </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                        @forelse ($history as $hs)
                                        <tr>
                                            <td>
                                                {{$hs->no_badge}}
                                            </td>
                                            <td>
                                                {{$hs->nama_driver}}
                                            </td>
                                            <td>
                                                @if ($hs->penugasan == 0)
                                                0
                                                @else
                                                {{$hs->penugasan}}
                                                @endif
                                                penugasan
                                            </td>
                                            <td>
                                                @if ($hs->pembatalan == 0)
                                                0
                                                @else
                                                {{$hs->pembatalan}}
                                                @endif
                                                pembatalan
                                            </td>
                                            <td>
                                                @if ($hs->nonaktif == null)
                                                0
                                                @else
                                                {{$hs->nonaktif}}
                                                @endif
                                                hari
                                            </td>
                                            <td>
                                                @if ($hs->kecelakaan == 0)
                                                0
                                                @else
                                                {{$hs->kecelakaan}}
                                                @endif
                                                x
                                            </td>
                                            <td>
                                                @for ($i = 0; $i < $hs->rating; $i++)
                                                    <i class="bi bi-star-fill fs-2x" style="color:#ffad0f"></i>
                                                    @endfor
                                            </td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
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
@endsection

@push('scripts')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
@endpush
