@extends('layouts.backend.main')

@section('title','Vehicle Check | Main')
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
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Vehicle Check</span>
                        <span class="text-muted mt-1 fw-bold fs-7">More Than 3 Need Approval</span>
                    </h3>

                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#tab_avaliable">Available</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_unavaliable">Not Available</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    @if(session()->has('success'))
                    <!--begin::Alert-->
                    <div
                        class="alert alert-dismissible bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                        <!--begin::Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
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

                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="tab_avaliable" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_do_avaliable"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. Pengecekan</th>
                                        <th>Oleh</th>
                                        <th>Kendaraan</th>
                                        <th>Kilometer</th>
                                        <th>Status</th>
                                        <th>Pengecekan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengecekan->where('status_kendaraan','r') as $pc)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>VC_{{$pc->id_pengecekan}}</td>
                                        <td>{{$pc->nama_driver}}</td>
                                        <td>
                                            {{$pc->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-primary">{{$pc->no_polisi}}</span>
                                        </td>
                                        <td>{{$pc->km_kendaraan}}</td>
                                        <td>
                                            @if ($pc->status_kendaraan == 'r')
                                            <span class="badge badge-light-primary">Tersedia</span>
                                            @else
                                            <span class="badge badge-light-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pc->status_pengecekan == 'c')
                                            <span class="badge badge-light-success">Pengecekan Normal</span>
                                            @else
                                            <span class="badge badge-light-warning">Pengecekan Kecelakaan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('check.detail', $pc->id_pengecekan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Selengkapnya</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show " id="tab_unavaliable" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_do_unavaliable"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. Pengecekan</th>
                                        <th>Oleh</th>
                                        <th>Kendaraan</th>
                                        <th>Kilometer</th>
                                        <th>Status</th>
                                        <th>Pengecekan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengecekan->where('status_kendaraan','t') as $pc)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>VC_{{$pc->id_pengecekan}}</td>
                                        <td>{{$pc->nama_driver}}</td>
                                        <td>
                                            {{$pc->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-warning">{{$pc->no_polisi}}</span>
                                        </td>
                                        <td>{{$pc->km_kendaraan}}</td>
                                        <td>
                                            @if ($pc->status_kendaraan == 'r')
                                            <span class="badge badge-light-primary">Tersedia</span>
                                            @else
                                            <span class="badge badge-light-danger">Tidak Tersedia</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pc->status_pengecekan == 'c')
                                            <span class="badge badge-light-success">Normal Check</span>
                                            @else
                                            <span class="badge badge-light-warning">Accident check</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path
                                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#kt_modal_change_vechile{{ $loop->iteration }}"
                                                        class="menu-link px-3" type="button">Change Vechile</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="{{route('check.detail', $pc->id_pengecekan)}}"
                                                        class="menu-link px-3">Detail</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                    </div>
                </div>
                <!--begin::Body-->
            </div>

            @foreach ($pengecekan->where('status_kendaraan','t') as $pc)
            <!--begin::Modal - Change-->
            <div class=" modal fade" id="kt_modal_change_vechile{{ $loop->iteration }}" tabindex="-1" aria-hidden="true"
                modal-change="change">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content rounded">
                        <!--begin::Modal header-->
                        <div class="modal-header pb-0 border-0 justify-content-end">
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                            transform="rotate(-45 6 17.3137)" fill="black" />
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                            transform="rotate(45 7.41422 6)" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--begin::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                            <!--begin:Form-->
                            <form id="kt_modal_change_vehicle_form" class="form"
                                action="{{route('check.updateVehicle', $pc->id_do)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Change Vehicle</h1>
                                    <!--end::Title-->
                                </div>
                                <!--end::Heading-->
                                <!--begin::Input group-->
                                <div class="form-group d-flex mb-8 row">
                                    <!--begin::Label-->
                                    <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                        <span class="required">Old
                                            Vehicle</span>
                                    </label>
                                    <!--end::Label-->
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{$pc->nama_kendaraan}} | {{$pc->no_polisi}}" disabled />
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <label class="required fs-6 fw-bold mb-2">New
                                        Vehicle</label>
                                    <select class="form-select form-select-solid" data-control="select2"
                                        data-hide-search="false" data-placeholder="Choose Vehicle" id="id_kendaraan"
                                        name="id_kendaraan">
                                        <option value="">Choose Vehicle</option>
                                        @foreach ($kendaraan as $kd)
                                        <option value="{{$kd->id_kendaraan}}">
                                            {{$kd->nama_kendaraan}} |
                                            {{$kd->no_polisi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <button type="submit" id="kt_modal_change_vehicle_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please
                                            wait...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end:Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - Change-->
            @endforeach


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
    $("#kt_datatable_do_avaliable").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
    $("#kt_datatable_do_unavaliable").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
</script>
@endpush
