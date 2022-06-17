@extends('layouts.backend.main')

@section('title','Master | Kriteria Pengecekan')
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
                        <span class="card-label fw-bolder fs-3 mb-1">Data Kriteria Pengecekan</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{$kriteriaPengecekan->count()}} Kriteria Pengecekan</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        title="" data-bs-original-title="Tekan untuk menambah kriteria pengecekan">
                        <a href="#" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_new_feul">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Tambah Kriteria Pengecekan
                        </a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <table id="kt_datatable_example_5"
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th>No</th>
                                <th>Kriteria Pengecekan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteriaPengecekan as $kP)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$kP->nama_kriteria}}</td>
                                <td>
                                    @if ($kP->status == 'y')
                                    <span class="badge badge-light-primary">Aktif</span>
                                    @else
                                    <span class="badge badge-light-danger">Non Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        <a href="{{ route('dashboard.pengecekan.kriteria.edit',$kP->id_kriteria)}}"
                                            class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-pencil-square fs-6"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="{{ route('dashboard.pengecekan.jenis.index','id='.$kP->id_kriteria)}}"
                                            class="btn btn-light bnt-active-light-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class=" svg-icon svg-icon-3">
                                                <i class="bi bi-stack fs-6"></i>
                                            </span>
                                            Input Jenis Pengecekan
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

    <!--begin::Modal - New Target-->
    <div class="modal fade" id="kt_modal_new_feul" tabindex="-1" aria-hidden="true">
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
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black" />
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
                    <form id="kt_modal_new_feul_form" class="form"
                        action="{{route('dashboard.pengecekan.kriteria.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Input Kriteria Pengecekan</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="text-muted fw-bold fs-5">Jika memerlukan info lebih lanjut, silahkan klik
                                <a href="#" class="fw-bolder link-primary">Manual Book</a>.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Kriteria Pengecekan</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Sesuaikan dengan kebijakan perusahaan"></i>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid"
                                placeholder="Masukkan Nama Kriteria Pengecekan" name="nama_kriteria" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            {{-- <div class="col-md-6 fv-row"> --}}
                                <label class="required fs-6 fw-bold mb-2">Status (Aktif/Non Aktif)</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Status" id="status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="y">Aktif</option>
                                    <option value="t">Non Aktif</option>
                                </select>
                                {{--
                            </div> --}}
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_feul_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_new_feul_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
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
    <!--end::Modal - New Target-->
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

    "use strict";
    var KTModalNewTarget = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_new_feul")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_new_feul_form"),
                    t = document.getElementById("kt_modal_new_feul_submit"),
                    e = document.getElementById("kt_modal_new_feul_cancel"),
                    $(a.querySelector('[name="nama_kriteria"]')).on("change", (function () {
                        n.revalidateField("nama_kriteria")
                    })), n = FormValidation.formValidation(a, {
                        fields: {
                            nama_kriteria: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Kriteria Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 45,
                                        message: "Nama Kriteria Maksimal 45 Karakter"
                                        // }
                                    }
                                }
                            },
                            status: {
                                validators: {
                                    notEmpty: {
                                        message: "Status Kriteria Harus Diisi"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                // eleInvalidClass: "",
                                // eleValidClass: ""
                            })
                        }
                    }),
                    t.addEventListener("click", (function (e) {
                        e.preventDefault(), n && n.validate().then((function (e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Formulir telah berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function (t) {
                                    a.submit()
                                    t.isConfirmed && o.hide()
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })),
                    e.addEventListener("click", (function (t) {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah Anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function (t) {
                            t.value ? (a.reset(), o.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir Anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })))
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function () {
        KTModalNewTarget.init()
    }));
</script>
@endpush
