@extends('layouts.backend.main')

@section('title','Master | Driver')
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
                        <span class="card-label fw-bolder fs-3 mb-1">Data Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{$driver->count()}} Driver</span>
                    </h3>
                    <div class="card-toolbar btn-toolbar">
                        <div class="btn-group me-2" role="group">
                            <a href="{{ route('dashboard.driver.create') }}"
                                class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-trigger="hover" title=""
                                data-bs-original-title="Tekan untuk menambah driver">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                            transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Tambah Driver
                            </a>
                        </div>
                        <div class="btn-group me-2" role="group">
                            <button type="button" class="btn btn-light-primary btn-sm" data-bs-toggle="modal"
                                data-bs-placement="top" data-bs-trigger="hover" title=""
                                data-bs-original-title="Tekan untuk import data driver dengan Ms. Excel"
                                data-bs-target="#kt_modal_import_driver">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <i class="bi bi-file-pdf"></i></a>
                                </span>
                                <!--end::Svg Icon-->Import
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('dashboard.driver.password.all.reset') }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-trigger="hover" title=""
                                data-bs-original-title="Tekan untuk mereset semua username dan password driver"
                                class="btn btn-sm btn-light btn-active-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <i class="bi bi-bootstrap-reboot"></i>
                                </span>
                                <!--end::Svg Icon-->Reset
                            </a>
                        </div>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
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
                            <h5 class="mb-1">Pesan</h5>
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
                    <!--begin::Table container-->
                    <table id="kt_datatable_example_5"
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>No Badge</th>
                                <th>Driver</th>
                                <th>Departemen</th>
                                <th>Alamat</th>
                                <th>No. Tlpn</th>
                                <th>Usia</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($driver as $dr)
                            <tr class="odd">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dr->no_badge}}</td>
                                <td>
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden">
                                        <div class="symbol-label">
                                            <img @if ($dr->foto_driver != null)
                                            src="{{url('/assets/img_driver/'.$dr->foto_driver)}}"
                                            @else
                                            src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                            @endif
                                            class="w-100" />
                                        </div>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        {{$dr->nama_driver}}
                                    </div>
                                    <!--begin::User details-->
                                </td>
                                <td>
                                    @if ($dr->id_departemen == null)
                                    ---
                                    @endif
                                    {{$dr->nama_departemen}}
                                </td>
                                <td>{{$dr->alamat}}</td>
                                <td>{{$dr->no_tlp}}</td>
                                <td>{{$dr->umur}}</td>
                                <td>
                                    @if ($dr->status == 'y')
                                    <span class="badge badge-light-primary">Aktif</span>
                                    @else
                                    <span class="badge badge-light-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        @if ($dr->status == 'y')
                                        <a href="{{route('dashboard.driver.status.nonaktif', $dr->id_driver)}}"
                                            class=" btn btn-icon btn-bg-light btn-active-color-danger btn-sm me-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                                            title=""
                                            data-bs-original-title="Tekan untuk nonaktifkan driver"
                                            >
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                              <i class="bi bi-person-x"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        @else
                                        <a href="{{route('dashboard.driver.status.aktif', $dr->id_driver)}}"
                                            class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                                            title=""
                                            data-bs-original-title="Tekan untuk aktifkan driver"
                                            >
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                             <i class="bi bi-person-check"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        @endif
                                        <a href="{{route('dashboard.driver.edit', $dr->id_driver)}}"
                                            class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                                            title=""
                                            data-bs-original-title="Tekan untuk edit data driver">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-pencil-square fs-6"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="{{ route('dashboard.driver.password.reset.satu', $dr->id_driver)}}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                                            title=""
                                            data-bs-original-title="Tekan untuk mereset username dan password driver"
                                            class=" btn btn-icon btn-bg-warning btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-bootstrap-reboot"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <div class="modal fade" id="kt_modal_import_driver" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-450px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Import Data Driver</h2>
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
                    <form id="kt_modal_import_driver_form" class="form"
                        action="{{route('dashboard.driver.import.excel')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="required fs-5 fw-bold form-label mb-5">File Excel Data Driver:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" class="form-control form-control-solid"
                                placeholder="Masukkan Berkas Excel" name="excel_driver" />
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
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/js/custom/documentation/documentation.js') }}"></script>
<script src="{{ url('assets/backend/assets/js/custom/documentation/search.js') }}"></script>
{{-- <script src="{{ url('assets/backend/assets/js/custom/documentation/general/datatables/advanced.js') }}"></script>
--}}
<!--end::Page Custom Javascript-->
<script text="text/javascipt">
    $(document).ready( function () {
        $("#kt_datatable_example_5").DataTable({
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

    var KTModalImportDriver= function() {
        const t = document.getElementById("kt_modal_import_driver"),
            e = t.querySelector("#kt_modal_import_driver_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                ! function() {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            excel_driver: {
                                validators: {
                                    notEmpty: {
                                        message: "File Wajib Diisi"
                                    },
                                    file: {
                                        extension: 'xls,xlsx',
                                        // type: 'application/xls/xlsx',
                                        message: 'File tidak falid'
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
                                    text: "Import Anda Sedang Diproses, Mohon Tunggu!",
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
                            text: "Apakah Anda Yakin Membatalkan Import?",
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
                                text: "Import Anda Dibatalkan!.",
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
                            text: "Apakah Anda Yakin Membatalkan Import?",
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
        KTModalImportDriver.init()
    }));
</script>
@endpush
