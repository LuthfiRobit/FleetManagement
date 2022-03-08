@extends('layouts.backend.main')

@section('title','Penugasan Driver | Terima')
@section('style-on-this-page-only')
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="card mb-5 mb-xl-8">
                <div class="card-body py-3">
                    <!--begin::Form-->
                    <form id="kt_form_accept" class="form"
                        action="{{route('checking.serviceorder.accept', $so->id_so)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h3 class="mb-2 mt-2">Buat Penugasan</h3>
                            <h4 class="mb-2 mt-2">SO_{{$so->no_so}}</h4>
                            <span class="mt-1 fw-bold fs-7">Pemesan : {{$so->petugas}} | Jabatan :
                                {{$so->jabatan}} | {{$so->departemen}}</span>
                            <!--end::Title-->
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
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Kendaraan</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Kendaraan" id="id_kendaraan"
                                    name="id_kendaraan">
                                    {{-- <option value="">Pilih Kendaraan</option> --}}
                                    @foreach ($kendaraan as $kd)
                                    <option value="{{$kd->id_kendaraan}}" data-sim="{{$kd->id_jenis_sim}}">
                                        {{$kd->alokasi}} | {{$kd->nama_kendaraan}} | {{$kd->no_polisi}} |
                                        {{$kd->sim}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Driver</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Driver" id="id_driver"
                                    name="id_driver">
                                    {{-- <option value="">Pilih Driver</option> --}}
                                    @foreach ($driver as $dr)
                                    <option value="{{$dr->id_driver}}">{{$dr->no_badge}} | {{$dr->nama_driver}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tempat Penjemputan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Jangan Hapus Tempat Penjemputan, Otomatis Terisi Sesuai SO"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Otomatis Terisi Sesuai SO" name="tmp_jemput"
                                    value="{{$so->tmp_jemput}}" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tujuan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Jangan Hapus Tempat Tujuan, Otomatis Terisi Sesuai SO"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Otomatis Terisi Sesuai SO" name="tmp_tujuan"
                                    value="{{$so->tmp_tujuan}}" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kembali</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Tentukan Tempat Kembali Driver."></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi Tempat Kembali Driver" name="kembali" />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-3">
                            <button type="reset" id="kt_button_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_button_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon Tunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
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
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<!--end::Page Vendors Javascript-->
<script text="text/javascipt">
    // $(function () {
    //     $('#id_kendaraan').on('change', function () {
    //     var id_sim =  $(this).val();
    //         // alert($(this).find(':selected').data('sim'));
    //         $.ajax({
    //             // url: 'http://127.0.0.1:8000/driver/select?id_sim='+id_sim+'&id_so='+{{$so->id_so}},
    //             url : '{{route("driver.select")}}',
    //             method: 'GET',
    //             // error: (result) => $.Notification.error(result),
    //             data: {
    //                 // 'id_sim': $(this).val(),
    //                 'id_sim': $(this).find(':selected').data('sim'),
    //                 'id_so': {{$so->id_so}}
    //                 },
    //             dataType: 'json',
    //             success: function (result) {
    //                 console.log(result);
    //                 console.log(result.Success);
    //                 console.log(result.Driver);
    //                 if (result.Success == true) {
    //                     $('#id_driver').empty();
    //                     var driver = result.Driver;
    //                     $.each(driver, function (key, item) {
    //                         $('#id_driver').append($('<option></option>').attr('value', item.id_driver).text(item.nama_driver));
    //                             // $('option', this).each(function () {
    //                             //     if ($(this).html() == item.nama_driver) {
    //                             //         $(this).attr('selected', 'selected')
    //                             //     };
    //                             // });
    //                     })
    //                 } else {
    //                     alert(result.Message);
    //                     $('#id_driver').empty();
    //                 }
    //             }
    //         })
    //     });
    //     // $('#id_driver').on('change', function () {
    //     //     id_sim =  $(this).val();
    //     //     alert(id_sim);
    //     // });
    // });

    var KTFormAccept = function () {
        var t, e, n, a, i;
        return {
            init: function () {
                (
                    a = document.querySelector("#kt_form_accept"),
                    t = document.getElementById("kt_button_submit"),
                    e = document.getElementById("kt_button_cancel")
                    , n = FormValidation.formValidation(a, {
                        fields: {
                            id_kendaraan: {
                                validators: {
                                    notEmpty: {
                                        message: "Kendaraan Harus Dipilih"
                                    }
                                }
                            },
                            id_driver: {
                                validators: {
                                    notEmpty: {
                                        message: "Driver Harus Dipilih"
                                    }
                                }
                            },
                            tmp_jemput: {
                                validators: {
                                    notEmpty: {
                                        message: "Pejemputan Tidak Boleh Kosong, Jangan Hapus Tujuan!"
                                    }
                                }
                            },
                            tmp_tujuan: {
                                validators: {
                                    notEmpty: {
                                        message: "Tujuan Tidak Boleh Kosong, Jangan Hapus Tujuan!"
                                    }
                                }
                            },
                            kembali: {
                                validators: {
                                    notEmpty: {
                                        message: "Kembali Harus Diisi"
                                    }
                                }
                            },
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
                            (a.reset(), window.location.href = "{{route('checking.serviceorder.detail',$so->id_so)}}") : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir Anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }))
                )
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function () {
        KTFormAccept.init()
    }));
</script>
@endpush
