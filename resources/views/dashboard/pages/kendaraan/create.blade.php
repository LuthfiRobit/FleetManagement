@extends('layouts.backend.main')

@section('title','Master | Kendaraan')

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
                    <form id="kt_modal_new_target_form" class="form"
                        action="{{ route('dashboard.kendaraan.main.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Input Kendaraan</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="text-muted fw-bold fs-5">Jika memerlukan info lebih lanjut, silahkan klik
                                <a href="#" class="fw-bolder link-primary">Manual Book</a>.
                            </div>
                            <!--end::Description-->
                            @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                                    <i class="bi bi-exclamation-triangle fs-1"></i>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-danger">This is an alert</h4>
                                    <span>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->

                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kode Asset</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Kode Asset" name="kode_asset" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Nama Kendaraan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Nama Kendaraan" name="nama_kendaraan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Pemilik</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Pemilik" id="pemilik"
                                    name="pemilik">
                                    <option value="">Pilih Pemilik</option>
                                    <option value="p">Perusahaan</option>
                                    <option value="u">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Polisi</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Polisi" name="no_polisi" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Rangka</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Rangka" name="nomor_rangka" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. Mesin</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan No. Mesin" name="nomor_mesin" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Jenis</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Jenis" id="id_jenis_kendaraan"
                                    name="id_jenis_kendaraan">
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($jenisKendaraan as $jK)
                                    <option value="{{$jK->id_jenis_kendaraan}}">{{$jK->nama_jenis}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Alokasi</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Alokasi" id="id_jenis_alokasi"
                                    name="id_jenis_alokasi">
                                    <option value="">Pilih Alokasi</option>
                                    @foreach ($jenisAlokasi as $ja)
                                    <option value="{{$ja->id_jenis_alokasi}}">{{$ja->nama_alokasi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Jenis SIM</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Jenis SIM" id="id_jenis_sim"
                                    name="id_jenis_sim">
                                    <option value="">Pilih Jenis SIM</option>
                                    @foreach ($jenisSim as $js)
                                    <option value="{{$js->id_jenis_sim}}">{{$js->nama_sim}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Merk</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Merk" id="id_merk" name="id_merk">
                                    <option value="">Pilih Merk</option>
                                    @foreach ($merkKendaraan as $mK)
                                    <option value="{{$mK->id_merk}}">{{$mK->nama_merk}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Bahan Bakar</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Bahan Bakar" id="id_bahan_bakar"
                                    name="id_bahan_bakar">
                                    <option value="">Pilih Merk</option>
                                    @foreach ($bahanBakar as $bB)
                                    <option value="{{$bB->id_bahan_bakar}}">{{$bB->nama_bahan_bakar}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Warna</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="Masukkan Warna"
                                    name="warna" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Jenis Penggerak</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Jenis Penggerak" name="jenis_penggerak" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tanggal Beli</span>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Masukkan Tanggal Pembelian" name="tanggal_pembelian" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tahun Kendaraan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Tahun Kendaraan" name="tahun_kendaraan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Harga</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" class="form-control form-control-solid"
                                    placeholder="Masukkan Harga Beli" name="harga" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Status</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Status" id="status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="y">Tesedia</option>
                                    <option value="t">Tidak Tersedia</option>
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
                // $(a.querySelector('[name="kode_asset"]')).on("change", (function () {
                //     n.revalidateField("kode_asset")
                // })),
                // $(a.querySelector('[name="nama_kendaraan"]')).on("change", (function () {
                //     n.revalidateField("nama_kendaraan")
                // })),
                // $(a.querySelector('[name="no_badge"]')).on("change", (function () {
                //     n.revalidateField("no_badge")
                // })),
                // $(a.querySelector('[name="no_polisi"]')).on("change", (function () {
                //     n.revalidateField("no_polisi")
                // })),
                // $(a.querySelector('[name="nomor_rangka"]')).on("change", (function () {
                //     n.revalidateField("nomor_rangka")
                // })),
                // $(a.querySelector('[name="nomor_mesin"]')).on("change", (function () {
                //     n.revalidateField("nomor_mesin")
                // })),
                // $(a.querySelector('[name="warna"]')).on("change", (function () {
                //     n.revalidateField("warna")
                // })),
                // $(a.querySelector('[name="jenis_penggerak"]')).on("change", (function () {
                //     n.revalidateField("jenis_penggerak")
                // })),
                // $(a.querySelector('[name="tanggal_pembelian"]')).on("change", (function () {
                //     n.revalidateField("tanggal_pembelian")
                // })),
                // $(a.querySelector('[name="harga"]')).on("change", (function () {
                //     n.revalidateField("harga")
                // }))
                , n = FormValidation.formValidation(a, {
                    fields: {
                        kode_asset: {
                            validators: {
                                notEmpty: {
                                    message: "Kode Asset Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 20,
                                    message: "Kode Asset Maksimal 20 Karakter"
                                    // }
                                }
                            }
                        },
                        nama_kendaraan: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Kendaraan Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 20,
                                    message: "Nama Kendaraan Maksimal 20 Karakter"
                                    // }
                                }
                            }
                        },
                        pemilik: {
                            validators: {
                                notEmpty: {
                                    message: "Pemilik Harus Diisi"
                                }
                            }
                        },
                        no_polisi: {
                            validators: {
                                notEmpty: {
                                    message: "No. Polisi Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 11,
                                    message: "No. Polisi Maksimal 11 Karakter"
                                    // }
                                }
                            }
                        },
                        nomor_rangka: {
                            validators: {
                                notEmpty: {
                                    message: "No. Rangka Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "No. Rangka Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        nomor_mesin: {
                            validators: {
                                notEmpty: {
                                    message: "No. Mesin Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "No. Mesin Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        warna: {
                            validators: {
                                notEmpty: {
                                    message: "Warna Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 20,
                                    message: "Warna Maksimal 20 Karakter"
                                    // }
                                }
                            }
                        },
                        jenis_penggerak: {
                            validators: {
                                notEmpty: {
                                    message: "Jenis Penggerak Harus Diisi"
                                },
                                // stringLength: {
                                //     // options: {
                                //     max: 8,
                                //     message: "Jenis Penggerak Maksimal 8 Karakter"
                                //     // }
                                // }
                            }
                        },
                        tanggal_pembelian: {
                            validators: {
                                notEmpty: {
                                    message: "Tanggal Pembelian Harus Diisi"
                                }
                            }
                        },
                        tahun_kendaraan: {
                            validators: {
                                notEmpty: {
                                    message: "Tahun Kendaraan Harus Diisi"
                                }
                            }
                        },
                        harga: {
                            validators: {
                                notEmpty: {
                                    message: "Harga Harus Diisi"
                                }
                            }
                        },
                        status: {
                            validators: {
                                notEmpty: {
                                    message: "Status Harus Diisi"
                                }
                            }
                        },
                        id_jenis_kendaraan: {
                            validators: {
                                notEmpty: {
                                    message: "Jenis Kendaraan Harus Diisi"
                                }
                            }
                        },
                        id_jenis_alokasi: {
                            validators: {
                                notEmpty: {
                                    message: "Alokasi Kendaraan Harus Diisi"
                                }
                            }
                        },
                        id_jenis_sim: {
                            validators: {
                                notEmpty: {
                                    message: "Jenis SIM Kendaraan Harus Diisi"
                                }
                            }
                        },
                        id_merk: {
                            validators: {
                                notEmpty: {
                                    message: "Merk Kendaraan Harus Diisi"
                                }
                            }
                        },
                        id_bahan_bakar: {
                            validators: {
                                notEmpty: {
                                    message: "Bahan Bakar Harus Diisi"
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

                        t.value ?
                        (a.reset(), window.location.href = "{{ route('dashboard.kendaraan.main.index')}}") : "cancel" === t.dismiss && Swal.fire({
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
