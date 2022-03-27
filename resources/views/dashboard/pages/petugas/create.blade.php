@extends('layouts.backend.main')

@section('title','Master | Petugas')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    {{-- <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Input Data Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7">=========================</span>
                    </h3> --}}

                </div>
                <!--end::Header-->
                <!--begin::Body-->

                <div class="card-body py-3">
                    <!--begin::Form-->
                    <form id="kt_modal_new_target_form" class="form" action="{{ route('dashboard.petugas.main.store')}}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Input Petugas</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <!--end::Description-->
                            @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                                    <i class="bi bi-exclamation-triangle fs-1"></i>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-danger">Pesan Error</h4>
                                    <span>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                </div>
                                <!--begin::Close-->
                                <button type="button"
                                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                                    data-bs-dismiss="alert">
                                    <i class="bi bi-x fs-1 text-danger"></i>
                                </button>
                                <!--end::Close-->
                            </div>
                            @endif
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->

                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Badge</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Badge" name="no_badge" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Departemen</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Departemen" id="id_departemen"
                                    name="id_departemen">
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departemen as $dp)
                                    <option value="{{$dp->id_departemen}}">{{$dp->nama_departemen}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Jabatan</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Jabatan" id="id_jabatan"
                                    name="id_jabatan">
                                    <option value="">Pilih Jabatan</option>
                                    @foreach ($jabatan as $jb)
                                    <option value="{{$jb->id_jabatan}}">{{$jb->nama_jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Nama Petugas</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Nama Petugas" name="nama_lengkap" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tempat Lahir</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Tempat Lahir" name="tempat_lahir" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tanggal Lahir</span>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Masukkan Tanggal Lahir" name="tgl_lahir" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Tlpn</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Tlpn" name="no_tlp" />
                            </div>
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tanggal Mulai Kerja</span>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Masukkan Tanggal Mulai Kerja" name="tgl_mulai_kerja" />
                            </div>
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Foto Profil</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" class="form-control form-control-solid"
                                    placeholder="Masukkan Foto Profil" name="foto_petugas" id="foto_petugas" />
                            </div>
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Status</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Status" id="status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="y">Aktif</option>
                                    <option value="t">Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-3">
                            <button type="reset" id="kt_modal_new_target_cancel"
                                class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
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
{{-- <script src="{{url('assets/backend/assets/js/custom/modals/new-target.js')}}">
</script> --}}
<script text="text/javascript">
    "use strict";
    var KTModalNewTarget = function () {
        var t, e, n, a, i;
        return {
            init: function () {
                (
                    a = document.querySelector("#kt_modal_new_target_form"),
                    t = document.getElementById("kt_modal_new_target_submit"),
                    e = document.getElementById("kt_modal_new_target_cancel")
                    , n = FormValidation.formValidation(a, {
                        fields: {
                            no_badge: {
                                validators: {
                                    notEmpty: {
                                        message: "No. Badge Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 10,
                                        message: "No. Badge Maksimal 10 Karakter"
                                        // }
                                    }
                                }
                            },
                            id_departemen: {
                                validators: {
                                    notEmpty: {
                                        message: "Departemen Harus Diisi"
                                    }
                                }
                            },
                            id_jabatan: {
                                validators: {
                                    notEmpty: {
                                        message: "Jabatan Harus Diisi"
                                    }
                                }
                            },
                            nama_lengkap: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Lengkap Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 45,
                                        message: "Nama Lengkap Maksimal 45 Karakter"
                                        // }
                                    }
                                }
                            },
                            tempat_lahir: {
                                validators: {
                                    notEmpty: {
                                        message: "Tempat Lahir Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 20,
                                        message: "Tempat Lahir Maksimal 20 Karakter"
                                        // }
                                    }
                                }
                            },
                            tgl_lahir: {
                                validators: {
                                    notEmpty: {
                                        message: "Tanggal Lahir Harus Diisi"
                                    }
                                }
                            },
                            no_tlp: {
                                validators: {
                                    notEmpty: {
                                        message: "No. Tlpn Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 12,
                                        message: "No. Tlpn Maksimal 12 Karakter"
                                        // }
                                    }
                                }
                            },
                            tgl_mulai_kerja: {
                                validators: {
                                    notEmpty: {
                                        message: "Tanggal Mulai Kerja Harus Diisi"
                                    }
                                }
                            },
                            foto_petugas: {
                                validators: {
                                    notEmpty: {
                                        message: "Foto Profil Harus Diisi"
                                    }
                                }
                            },
                            status: {
                                validators: {
                                    notEmpty: {
                                        message: "Status Harus Diisi"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".row",
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
                                    confirmButtonText: "Ok, mengerti!",
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
                                confirmButtonText: "Ok, mengerti!",
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
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function (t) {

                            t.value ?
                            (a.reset(), window.location.href = "{{ route('dashboard.petugas.main.index')}}") : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir Anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
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
