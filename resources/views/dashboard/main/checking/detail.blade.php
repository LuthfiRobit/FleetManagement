@extends('layouts.backend.main')

@section('title','Vehicle Check | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">Detail Vechile Check</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Checked By : {{$pengecekan->nama_driver}}</span>
                    </h3>
                </div>
            </div>
            <!--begin:: Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--end:: sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->
                            <!--begin::User Info-->
                            <div class="d-flex flex-center flex-column py-5">
                                <!--begin::Name-->
                                <a href="#"
                                    class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$pengecekan->nama_kendaraan}}</a>
                                <!--end::Name-->
                            </div>
                            <div class="d-flex flex-wrap flex-center">
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span class="w-75px">{{$pengecekan->kode_asset}}</span>
                                    </div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span class="w-75px">{{$pengecekan->no_polisi}}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bolder rotate collapsible collapsed">Detail Vehicle
                                </div>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details">
                                <div class="pb-5 fs-6">
                                    <div class="fw-bolder mt-5">Latest Kilometers</div>
                                    <div class="text-gray-600">{{$pengecekan->km_kendaraan}} Km</div>
                                    <div class="fw-bolder mt-5">Merk</div>
                                    <div class="text-gray-600">{{$pengecekan->merk}} </div>
                                    <div class="fw-bolder mt-5">Type</div>
                                    <div class="text-gray-600">{{$pengecekan->jenis}}</div>
                                    <div class="fw-bolder mt-5">Fuel</div>
                                    <div class="text-gray-600">{{$pengecekan->bahan_bakar}}</div>
                                    <div class="fw-bolder mt-5">Color</div>
                                    <div class="text-gray-600">{{$pengecekan->warna}}</div>
                                    <div class="fw-bolder mt-5">Drive Type</div>
                                    <div class="text-gray-600">{{$pengecekan->jenis_penggerak}}</div>
                                </div>
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:: sidebar-->
                <!--begin:: content-->
                <div class="flex-lg-row-fluid ms-lg-15" id="kt_table_users">
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">ID Vehicle Check</h2>
                                <div class="fs-6 fw-bold text-muted">VC_{{$pengecekan->id_pengecekan}} |
                                    @if($pengecekan->status_pengecekan == 'c')
                                    <span class="badge badge-light-success">Normal Check</span>
                                    @else
                                    <span class="badge badge-light-warning">Accident check</span>
                                    @endif
                                </div>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Add-->
                                <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                    <!--end::Svg Icon-->Actions
                                </button>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_accept">Repair</a>
                                        {{-- <a href="#" class="menu-link px-3" id="modal_accept"">Accept</a> --}}
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu item-->
                                 <div class=" menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_reject">Update Repairation</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Add-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Checking Date and
                                        Time</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{Carbon\Carbon::parse($pengecekan->tgl_pengecekan)->format('d F Y')}} |
                                        {{Carbon\Carbon::parse($pengecekan->jam_pengecekan)->format('H:i')}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5"
                                    id="kt_table_users_login_session">
                                    <!--begin::Table head-->
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">Criteria</th>
                                            <th>Type</th>
                                            <th>Condition</th>
                                            <th class="min-w-125px">Description</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        @foreach ($detail as $dp)
                                        <tr>
                                            <td>{{$dp->kriteria}}</td>
                                            <td>{{$dp->jenis}}</td>
                                            <td>
                                                @if($dp->kondisi == 'b')
                                                <span class="badge badge-light-success">Normal</span>
                                                @else
                                                <span class="badge badge-light-danger">Damaged</span>
                                                @endif
                                            </td>
                                            <td>{{$dp->keterangan}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:: content-->
            </div>
            <!--begin:: Layout-->
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
