@extends('layouts.backend.main')

@section('title','Laporan Perbaikan | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">LAPORAN PERBAIKAN KENDARAAN</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ada
                            {{$perbaikan->where('status_perbaikan','p')->count()}} Dalam Proses</span>
                    </h3>
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                            <!--begin::Export-->
                            <button type="button" class="btn btn-light-primary btn-sm mb-5" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_export_users">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                   <i class="bi bi-file-pdf"></i></a>
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
                                        <h2 class="fw-bolder">Export Perbaikan</h2>
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
                                            action="{{route('repair.export.pdf.filter')}}" method="GET"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="required fs-5 fw-bold form-label mb-5">Bulan</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <input type="month" class="form-control form-control-solid"
                                                    placeholder="Pilih Bulan" name="tgl_perbaikan" />
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="fv-row mb-10">
                                                <!--begin::Label-->
                                                <label class="fs-6 fw-bold form-label mb-2">Status Perbaikan:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="status" data-control="select2"
                                                    data-placeholder="Pilih Status" data-hide-search="true"
                                                    class="form-select form-select-solid fw-bolder">
                                                    <option></option>
                                                    <option value="p">Proses</option>
                                                    <option value="s">Selesai</option>
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
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_proses">PROSES</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#tab_done">SELESAI</a>
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
                        <div class="tab-pane fade show active" id="tab_proses" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_proses"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. WO</th>
                                        <th>Dealer</th>
                                        <th>Kendaraan</th>
                                        <th>Tgl. Mulai</th>
                                        <th>Tgl. Penyelesaian</th>
                                        <th>Status Perbaikan</th>
                                        <th>Status Penyelesaian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perbaikan->where('status_perbaikan','p') as $pr)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>WO_{{$pr->no_wo}}</td>
                                        <td>{{$pr->nama_dealer}}</td>
                                        <td>
                                            {{$pr->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-primary">{{$pr->no_polisi}}</span>
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_perbaikan)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_selesai)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            @if($pr->status_perbaikan == 's')
                                            <span class="badge badge-light-primary">SELESAI</span>
                                            @else
                                            <span class="badge badge-light-warning">PROSES</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pr->status_penyelesaian == 'o')
                                            <span class="badge badge-light-primary">ON TIME</span>
                                            @elseif($pr->status_penyelesaian == 'p')
                                            <span class="badge badge-light-danger">PENALTI</span>
                                            @else
                                            <span class="badge badge-light-warning">BELUM</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('repair.invoice', $pr->id_perbaikan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Selesaikan</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show " id="tab_done" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_done"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. WO</th>
                                        <th>Dealer</th>
                                        <th>Kendaraan</th>
                                        <th>Tgl. Mulai</th>
                                        <th>Tgl. Penyelesaian</th>
                                        <th>Status Perbaikan</th>
                                        <th>Status Penyelesaian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perbaikan->where('status_perbaikan','s') as $pr)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>WO_{{$pr->no_wo}}</td>
                                        <td>{{$pr->nama_dealer}}</td>
                                        <td>
                                            {{$pr->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-primary">{{$pr->no_polisi}}</span>
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_perbaikan)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_selesai)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            @if($pr->status_perbaikan == 's')
                                            <span class="badge badge-light-primary">SELESAI</span>
                                            @else
                                            <span class="badge badge-light-warning">PROSES</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pr->status_penyelesaian == 'o')
                                            <span class="badge badge-light-primary">ON TIME</span>
                                            @elseif($pr->status_penyelesaian == 'p')
                                            <span class="badge badge-light-danger">PENALTI</span>
                                            @else
                                            <span class="badge badge-light-warning">BELUM</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('repair.export.one', $pr->id_perbaikan)}}"
                                                class="btn btn-light bnt-active-light-success btn-sm mb-1">
                                                <i class="bi bi-file-pdf"></i></a>
                                            <a href="{{route('repair.detail', $pr->id_perbaikan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Detail</a>
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
    $(document).ready(function () {
        $("#kt_datatable_done").DataTable({
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

        $("#kt_datatable_proses").DataTable({
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
                            // status: {
                            //     validators: {
                            //         notEmpty: {
                            //             message: "Statu Harus Diisi"
                            //         }
                            //     }
                            // },
                            tgl_perbaikan: {
                                validators: {
                                    notEmpty: {
                                        message: "Bulan Harus Diisi"
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
                                    text: "Export Perbaikan Berhasil Dikirim, Mohon Tunggu!",
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
