@extends('layouts.backend.main')

@section('title','Laporan Pengecekan | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">LAPORAN PENGECEKAN</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ada
                            {{$pengecekan->where('status_perbaikan',null)->count()}} Butuh Persetujuan Perbaikan</span>
                    </h3>
                    <ul
                        class="align-items-end  nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#tab_avaliable">TERSEDIA</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_unavaliable">TIDAK TERSEDIA</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Export-->
                            <button type="button" class="btn btn-light-primary btn-sm mb-5" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_export_users">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-file-earmark-excel"></i></a>
                                </span>
                                <!--end::Svg Icon-->Export
                            </button>
                            <!--end::Export-->
                        </div>
                        <!--end::Toolbar-->
                        <!--begin::Modal - Adjust Balance-->
                        <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
                            <!--begin::Modal dialog-->
                            <div class="modal-dialog modal-dialog-centered mw-450px">
                                <!--begin::Modal content-->
                                <div class="modal-content">
                                    <!--begin::Modal header-->
                                    <div class="modal-header">
                                        <!--begin::Modal title-->
                                        <h2 class="fw-bolder">Export Excel Pengecekan</h2>
                                        <!--end::Modal title-->
                                        <!--begin::Close-->
                                        <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                            data-kt-users-modal-action="close">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
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
                                    <!--end::Modal header-->
                                    <!--begin::Modal body-->
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                        <!--begin::Form-->
                                        <form id="kt_modal_export_users_form" class="form"
                                            action="{{route('check.export.filter')}}" method="GET"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-bold form-label mb-5">Tgl.
                                                    Pengecekan:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="date" class="form-control form-control-solid"
                                                    placeholder="Pick a date" name="tgl_pengecekan" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mb-2">Pilih
                                                    Kendaraan:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="id_kendaraan" data-control="select2"
                                                    data-placeholder="Pilih Kendaraan" data-hide-search="true"
                                                    class="form-select form-select-solid fw-bolder">
                                                    <option></option>
                                                    @foreach ($kendaraan as $kd)
                                                    <option value="{{$kd->id_kendaraan}}">{{$kd->nama_kendaraan}} |
                                                        {{$kd->no_polisi}}</option>
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="text-center">
                                                <button type="reset" class="btn btn-light me-3"
                                                    data-kt-users-modal-action="cancel">Batal</button>
                                                <button type="submit" class="btn btn-primary"
                                                    data-kt-users-modal-action="submit">
                                                    <span class="indicator-label">Kirim</span>
                                                    <span class="indicator-progress">Mohon Tunggu...
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                </button>
                                            </div>
                                            <!--end::Actions-->
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Modal body-->
                                </div>
                                <!--end::Modal content-->
                            </div>
                            <!--end::Modal dialog-->
                        </div>
                        <!--end::Modal - New Card-->
                    </div>
                    <!--end::Card toolbar-->
                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin:::Tabs-->
                    {{-- <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#tab_avaliable">TERSEDIA</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_unavaliable">TIDAK TERSEDIA</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul> --}}
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
                                        <th>Tanggal</th>
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
                                        <td>{{ \Carbon\Carbon::parse($pc->tgl_pengecekan)->translatedFormat('d-m-Y') }}
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
                                            <span class="badge badge-light-primary">Normal</span>
                                            @else
                                            <span class="badge badge-light-danger">Kecelakaan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('check.detail', $pc->id_pengecekan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm mb-1">Detail</a>
                                            <a href="{{route('check.exprt.pdf.car', $pc->id_pengecekan)}}"
                                                class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-file-pdf"></i>
                                                </span>
                                            </a>
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
                                        <th>Tanggal</th>
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
                                        <td>{{ \Carbon\Carbon::parse($pc->tgl_pengecekan)->translatedFormat('d-m-Y') }}
                                        </td>
                                        <td>{{$pc->nama_driver}}</td>
                                        <td>
                                            {{$pc->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-warning">{{$pc->no_polisi}}</span>
                                        </td>
                                        <td>{{$pc->km_kendaraan}}</td>
                                        <td>
                                            @if ($pc->status_kendaraan == 'r')
                                            <span class="badge badge-light-primary">Normal</span>
                                            @else
                                            <span class="badge badge-light-danger">Rusak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pc->status_pengecekan == 'c')
                                            <span class="badge badge-light-primary">Harian</span>
                                            @else
                                            <span class="badge badge-light-danger">Kecelakaan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('check.detail', $pc->id_pengecekan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm mb-1">Detail</a>
                                            <a href="{{route('check.exprt.pdf.car', $pc->id_pengecekan)}}"
                                                class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <span class="svg-icon svg-icon-2">
                                                    <i class="bi bi-file-pdf"></i>
                                                </span>
                                            </a>
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

            {{-- @foreach ($pengecekan->where('status_kendaraan','t') as $pc)
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
            @endforeach --}}


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
    "use strict";
    var KTModalExportUsers = function() {
        const t = document.getElementById("kt_modal_export_users"),
            e = t.querySelector("#kt_modal_export_users_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                ! function() {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            tgl_pengecekan: {
                                validators: {
                                    notEmpty: {
                                        message: "Tgl. Pengecekan Wajib Diisi"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    });
                    const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                    i.addEventListener("click", (function(t) {
                        t.preventDefault(), o && o.validate().then((function(t) {
                            console.log("validated!"), "Valid" == t ? (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function() {
                                i.removeAttribute("data-kt-indicator"), Swal.fire({
                                    text: "Export Pengecekan Berhasil Dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function(t) {
                                    e.submit()
                                    t.isConfirmed && (n.hide(), i.disabled = !1)
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Silahkan Isi Field",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (function(t) {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah Anda Yakin Membatalkan Export?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Export Anda Dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (function(t) {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah Anda Yakin Membatalkan Export?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Export Anda Belum Dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }))
                }()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTModalExportUsers.init()
    }));
</script>
@endpush
