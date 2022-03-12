@extends('layouts.backend.main')

@section('title','Master | Dealer')

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
                        <span class="card-label fw-bolder fs-3 mb-1">Edit Dealer</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{ $dealer->nama_dealer}}</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
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
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <i class="bi bi-x fs-1 text-danger"></i>
                        </button>
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
                    <!--begin::Form-->
                    <form id="kt_modal_new_target_form" class="form"
                        action="{{ route('dashboard.dealer.update',$dealer->id_dealer)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Edit Departemen</h1>
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
                                <span class="required">Nama Dealer</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Sesuaikan dengan nama dealer"></i>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid"
                                placeholder="Masukkan Nama Dealer" name="nama_dealer"
                                value="{{$dealer->nama_dealer}}" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Alamat Dealer</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Sesuaikan dengan alamat dealer"></i>
                            </label>
                            <!--end::Label-->
                            <textarea name="alamat" class="form-control form-control-solid"
                                placeholder="Masukkan Alamat Dealer">{{$dealer->alamat}}</textarea>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">No. Tlfn</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Sesuaikan dengan no. telpon dealer"></i>
                            </label>
                            <!--end::Label-->
                            <input type="number" class="form-control form-control-solid"
                                placeholder="Masukkan No. Tlfn Dealer" name="no_tlp" value="{{$dealer->no_tlp}}" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            {{-- <div class="col-md-6 fv-row"> --}}
                                <label class="required fs-6 fw-bold mb-2">Status (Aktif / Non Aktif)</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="y" {{$dealer->status == 'y' ? 'selected' : ''}}>
                                        Aktif</option>
                                    <option value="t" {{$dealer->status == 't' ? 'selected' : ''}}>
                                        Non Aktif</option>
                                </select>
                                {{--
                            </div> --}}
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            {{-- <div class="col-md-6 fv-row"> --}}
                                <label class="required fs-6 fw-bold mb-2">Status Dealer (Milik
                                    Perusahaan/Rekanan)</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Status" name="status_dealer">
                                    <option value="">Pilih Status</option>
                                    <option value="p" {{$dealer->status_dealer == 'p' ? 'selected' : ''}}>Perusahaan
                                    </option>
                                    <option value="r" {{$dealer->status_dealer == 'r' ? 'selected' : ''}}>Rekanan
                                    </option>
                                </select>
                                {{--
                            </div> --}}
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_target_cancel"
                                class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
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
                e = document.getElementById("kt_modal_new_target_cancel"),
                $(a.querySelector('[name="nama_dealer"]')).on("change", (function () {
                    n.revalidateField("nama_dealer")
                })),
                $(a.querySelector('[name="alamat"]')).on("change", (function () {
                    n.revalidateField("alamat")
                })),
                $(a.querySelector('[name="no_tlp"]')).on("change", (function () {
                    n.revalidateField("no_tlp")
                }))
                , n = FormValidation.formValidation(a, {
                    fields: {
                        nama_dealer: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Dealer Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "Nama Dealer Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        alamat: {
                            validators: {
                                notEmpty: {
                                    message: "Alamat Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "Alamat Dealer Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        // no_tlp: {
                        //     validators: {
                        //         notEmpty: {
                        //             message: "No. Tlpn Dealer Harus Diisi"
                        //         },
                        //         stringLength: {
                        //             // options: {
                        //             max: 12,
                        //             message: "No. Tlpn Dealer Maksimal 12 Karakter"
                        //             // }
                        //         }
                        //     }
                        // },
                        status: {
                            validators: {
                                notEmpty: {
                                    message: "Status Harus Diisi"
                                }
                            }
                        },
                        status_dealer: {
                            validators: {
                                notEmpty: {
                                    message: "Status Dealer Harus Diisi"
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
                        (a.reset(), window.location.href = "{{ route('dashboard.dealer.index')}}") : "cancel" === t.dismiss && Swal.fire({
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
