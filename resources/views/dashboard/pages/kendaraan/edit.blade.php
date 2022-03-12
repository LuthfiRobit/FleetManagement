@extends('layouts.backend.main')

@section('title','Master | Kendaraan')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <!--begin::Form-->
                            <form id="kt_modal_new_target_form" class="form"
                                action="{{ route('dashboard.kendaraan.main.update', $kendaraan->id_kendaraan)}}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Heading-->
                                <div class="mb-13 text-center">
                                    <!--begin::Title-->
                                    <h1 class="mb-3">Edit Kendaraan</h1>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="text-muted fw-bold fs-5">Segera Lakukan Pengalokasian Kendaraan
                                        {{-- <a href="#" class="fw-bolder link-primary">Manual Book</a>. --}}
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none">
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
                                            <span class="required">Kode Asset</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Kode Asset" name="kode_asset"
                                            value="{{$kendaraan->kode_asset}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Nama Kendaraan</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Nama Kendaraan" name="nama_kendaraan"
                                            value="{{$kendaraan->nama_kendaraan}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="required fs-6 fw-bold mb-2">Pemilik</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Pemilik" id="pemilik"
                                            name="pemilik">
                                            <option value="">Pilih Pemilik</option>
                                            <option value="p" {{$kendaraan->pemilik == 'p' ? 'selected' :
                                                ''}}>Perusahaan
                                            </option>
                                            <option value="u" {{$kendaraan->pemilik == 'u' ? 'selected' : ''}}>User
                                            </option>
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
                                            placeholder="Masukkan No. Polisi" name="no_polisi"
                                            value="{{$kendaraan->no_polisi}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">No. Rangka</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan No. Rangka" name="nomor_rangka"
                                            value="{{$kendaraan->nomor_rangka}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">No. Mesin</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan No. Mesin" name="nomor_mesin"
                                            value="{{$kendaraan->nomor_mesin}}" />
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-6">
                                        <label class="required fs-6 fw-bold mb-2">Jenis</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Jenis"
                                            id="id_jenis_kendaraan" name="id_jenis_kendaraan">
                                            <option value="">Pilih Jenis</option>
                                            @foreach ($jenisKendaraan as $jK)
                                            <option value="{{$jK->id_jenis_kendaraan}}" {{$kendaraan->id_jenis_kendaraan
                                                ==
                                                $jK->id_jenis_kendaraan ? 'selected' : ''}}>
                                                {{$jK->nama_jenis}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <label class="required fs-6 fw-bold mb-2">Alokasi</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Alokasi"
                                            id="id_jenis_alokasi" name="id_jenis_alokasi">
                                            <option value="">Pilih Alokasi</option>
                                            @foreach ($jenisAlokasi as $ja)
                                            <option value="{{$ja->id_jenis_alokasi}}" {{$kendaraan->id_jenis_alokasi ==
                                                $ja->id_jenis_alokasi ? 'selected' : ''}}>{{$ja->nama_alokasi}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <label class="required fs-6 fw-bold mb-2">Jenis SIM</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Jenis SIM"
                                            id="id_jenis_sim" name="id_jenis_sim">
                                            <option value="">Pilih Jenis SIM</option>
                                            @foreach ($jenisSim as $js)
                                            <option value="{{$js->id_jenis_sim}}" {{$kendaraan->id_jenis_sim ==
                                                $js->id_jenis_sim ? 'selected' : ''}}>{{$js->nama_sim}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-6">
                                        <label class="required fs-6 fw-bold mb-2">Merk</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Merk" id="id_merk"
                                            name="id_merk">
                                            <option value="">Pilih Merk</option>
                                            @foreach ($merkKendaraan as $mK)
                                            <option value="{{$mK->id_merk}}" {{$kendaraan->id_merk ==
                                                $mK->id_merk ? 'selected' : ''}}>{{$mK->nama_merk}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="required fs-6 fw-bold mb-2">Bahan Bakar</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Bahan Bakar"
                                            id="id_bahan_bakar" name="id_bahan_bakar">
                                            <option value="">Pilih Merk</option>
                                            @foreach ($bahanBakar as $bB)
                                            <option value="{{$bB->id_bahan_bakar}}" {{$kendaraan->id_bahan_bakar ==
                                                $bB->id_bahan_bakar ? 'selected' : ''}}>{{$bB->nama_bahan_bakar}}
                                            </option>
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
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Warna" name="warna" value="{{$kendaraan->warna}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Jenis Penggerak</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Jenis Penggerak" name="jenis_penggerak"
                                            value="{{$kendaraan->jenis_penggerak}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Tanggal Beli</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="date" class="form-control form-control-solid"
                                            placeholder="Masukkan Tanggal Pembelian" name="tanggal_pembelian"
                                            value="{{$kendaraan->tanggal_pembelian}}" />
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Kahun Kendaraan</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Tahun Kendaraan" name="tahun_kendaraan"
                                            value="{{$kendaraan->tahun_kendaraan}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Harga</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="number" class="form-control form-control-solid"
                                            placeholder="Masukkan Harga Beli" name="harga"
                                            value="{{$kendaraan->harga}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="required fs-6 fw-bold mb-2">Status</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Status" id="status"
                                            name="status">
                                            <option value="">Pilih Status</option>
                                            <option value="y" {{$kendaraan->status == 'y' ? 'selected' : ''}}>Tesedia
                                            </option>
                                            <option value="t" {{$kendaraan->status == 't' ? 'selected' : ''}}>Tidak
                                                Tersedia
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center mt-3">
                                    <button type="reset" id="kt_modal_new_target_cancel"
                                        class="btn btn-light me-3">Batal</button>
                                    <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Mohon Tunggu...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end:Form-->
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>ALOKASI KENDARAAN</h2>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-5">
                                <table class="table fs-6 fw-bold gs-0 gy-0 gx-0">
                                    <!--begin::Row-->
                                    @foreach($alokasiKendaraan as $ak)
                                    <tr class="">
                                        <td class="text-black-400">{{$ak->nama_alokasi}}</td>
                                        <td class="text-gray-800 text-end">
                                            <button type="button"
                                                class="btn remove btn-sm btn-icon btn-active-color-primary"
                                                data-id="{{$ak->id_alokasi}}">
                                                <i class="bi bi-trash fs-3"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <!--begin::Row-->
                                </table>
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <form action="{{route('dashboard.kendaraan.alokasi.simpan')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id_kendaraan" value="{{$kendaraan->id_kendaraan}}">
                                <div class="">
                                    <label class="required fs-6 fw-bold mb-2">Tambah Alokasi</label>
                                    <select class="form-select form-select-solid me-10" data-control="select2"
                                        data-hide-search="false" data-placeholder="Pilih Alokasi" id="id_jenis_alokasi"
                                        name="id_jenis_alokasi">
                                        {{-- <option value="">Pilih Alokasi</option> --}}
                                        @foreach ($jenisAlokasi as $ja)
                                        <option value="{{$ja->id_jenis_alokasi}}">{{$ja->nama_alokasi}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center my-3">
                                    <button type="submit" id="kt_modal_new_target_submit"
                                        class="btn btn-primary btn-sm">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Mohon Tunggu...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
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
    var KTModalNewTarget = function() {
        var t, e, n, a, i;
        return {
            init: function() {
                (
                    a = document.querySelector("#kt_modal_new_target_form"),
                    t = document.getElementById("kt_modal_new_target_submit"),
                    e = document.getElementById("kt_modal_new_target_cancel")
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
                                    //     min: 8,
                                    //     message: "Jenis Penggerak Minimal 8 Karakter"
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
                            // harga: {
                            //     validators: {
                            //         notEmpty: {
                            //             message: "Harga Harus Diisi"
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
                            id_jenis_kendaraan: {
                                validators: {
                                    notEmpty: {
                                        message: "Jenis Kendaraan Harus Diisi"
                                    }
                                }
                            },
                            // id_jenis_alokasi: {
                            //     validators: {
                            //         notEmpty: {
                            //             message: "Alokasi Kendaraan Harus Diisi"
                            //         }
                            //     }
                            // },
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
                    t.addEventListener("click", (function(e) {
                        e.preventDefault(), n && n.validate().then((function(e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function() {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Formulir telah berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function(t) {
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
                    e.addEventListener("click", (function(t) {
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
                        }).then((function(t) {

                            t.value ?
                                (a.reset(), window.location.href = "{{ route('dashboard.kendaraan.main.index')}}") : "cancel" === t.dismiss && Swal.fire({
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
    KTUtil.onDOMContentLoaded((function() {
        KTModalNewTarget.init()
    }));

    $(function () {
        var replyBtns = document.querySelectorAll('button.remove');
        for (var i = 0; i < replyBtns.length; i++) {
        replyBtns[i].addEventListener('click', function(e) {
            var  t;
            t = $(this);
            $.ajax({
                type: 'POST',
                url: '{{route("dashboard.kendaraan.alokasi.hapus")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id_alokasi': $(this).data('id')
                    // 'jml':$(this).val()
                },
                datatype: 'JSON',
                success: function (response) {
                    Swal.fire(
                        'Berhasil!',
                        'Alokasi Terhapus',
                        'success'
                        )
                    t.parent().parent().remove();
                    console.log(response);
                },
                error: function (response) {
                    // t.parent().parent().remove();
                    // alert('Gagal Menghapus');
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat mengapus alokasi',
                        'error'
                        )
                    console.log(response);
                }
            });
            // alert($(this).data('id'));
            // this.parentNode.parentNode.remove(this.parentNode);
        }, false);
        }
    });
</script>
@endpush
