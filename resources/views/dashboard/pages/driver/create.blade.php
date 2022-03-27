@extends('layouts.backend.main')

@section('title','Master | Driver')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                </div>
                <!--end::Header-->
                <!--begin::Body-->

                <div class="card-body py-3">
                    <!--begin::Form-->
                    <form id="kt_modal_new_target_form" class="form" action="{{ route('dashboard.driver.store')}}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Input Driver</h1>
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
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->

                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">NO BADGE</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="No Badge Akan Otomatis Menjadi Username"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan NO BADGE" name="no_badge" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Nama Driver</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Nama Driver" name="nama_driver" />
                            </div>
                            <div class="col-lg-4">
                                <label class="fs-6 fw-bold mb-2">Departemen</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Departemen" id="id_departemen"
                                    name="id_departemen">
                                    <option value="">Pilih Status</option>
                                    @foreach ($departemen as $dt)
                                    <option value="{{$dt->id_departemen}}">{{$dt->nama_departemen}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Usia</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" class="form-control form-control-solid" placeholder="Masukkan Usia"
                                    name="umur" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Tlpn</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="No. Telpon Akan Otomatis Menjadi Password"></i>
                                </label>
                                <!--end::Label-->
                                <input type="number" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Tlpn" name="no_tlp" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Alamat</span>
                                </label>
                                <textarea name="alamat" class="form-control form-control-solid"
                                    placeholder="Masukkan Alamat Driver"></textarea>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Foto Profil</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" class="form-control form-control-solid"
                                    placeholder="Masukkan Foto Profil" name="foto_driver" id="foto_driver" />
                            </div>
                            <div class="col-lg-6">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Foto Ktp</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" class="form-control form-control-solid"
                                    placeholder="Masukkan Foto KTP" name="foto_ktp" id="foto_ktp" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Jenis SIM</span>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Jenis SIM" id="id_jenis_sim"
                                    name="id_jenis_sim">
                                    <option value="">Pilih Jenis SIM</option>
                                    @foreach ($jenisSim as $js)
                                    <option value="{{$js->id_jenis_sim}}">{{$js->nama_sim}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Foto SIM</span>
                                </label>
                                <!--end::Label-->
                                <input type="file" class="form-control form-control-solid"
                                    placeholder="Masukkan Foto SIM" name="foto_sim" id="foto_sim" />
                            </div>
                        </div>

                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-3">
                            <button type="reset" id="kt_modal_new_target_cancel"
                                class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Kirim</span>
                                <span class="indicator-progress">Mohon Tunggu...
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
                        nama_driver: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Driver Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "Nama Driver Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        no_badge: {
                            validators: {
                                notEmpty: {
                                    message: "NO Badge Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 10,
                                    message: "NO Badge Maksimal 10 Karakter"
                                    // }
                                }
                            }
                        },
                        // id_departemen: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: "Departemen Harus Dipilih"
                        //         }
                        //     }
                        // },
                        alamat: {
                            validators: {
                                notEmpty: {
                                    message: "Alamat Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 60,
                                    message: "Alamat Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        umur: {
                            validators: {
                                notEmpty: {
                                    message: "Usia Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 3,
                                    message: "Usia Maksimal 3 Karakter"
                                    // }
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
                        foto_driver: {
                            validators: {
                                notEmpty: {
                                    message: "Foto Profil Harus Diisi"
                                }
                            }
                        },
                        foto_ktp: {
                            validators: {
                                notEmpty: {
                                    message: "Foto KTP Harus Diisi"
                                }
                            }
                        },
                        id_jenis_sim: {
                            validators: {
                                notEmpty: {
                                    message: "Jenis SIM Harus Diisi"
                                }
                            }
                        },
                        foto_sim: {
                            validators: {
                                notEmpty: {
                                    message: "Foto SIM Harus Diisi"
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
                        (a.reset(), window.location.href = "{{ route('dashboard.driver.index')}}") : "cancel" === t.dismiss && Swal.fire({
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
