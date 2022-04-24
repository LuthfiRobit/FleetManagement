@extends('layouts.backend.main')

@section('title','Penugasan Driver | Pembuatan')
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
                    <form id="kt_form_accept" class="form" method="POST" enctype="multipart/form-data"
                        action="{{route('checking.serviceorder.create')}}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h3 class="mb-2 mt-2">Buat Penugasan</h3>
                            <h4 class="mb-2 mt-2">Sesuaikan data dengan surat SO</span>
                                <!--end::Title-->
                                @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                                        <i class="bi bi-exclamation-triangle fs-1"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Errors</h4>
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
                                    <span class="required">No. SO</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="Isi No. So"
                                    name="no_so" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tujuan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat tujuan" name="tmp_tujuan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat penjemputan" name="tmp_penjemputan" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Agenda</span>
                                </label>
                                <!--end::Label-->
                                <textarea type="text" class="form-control form-control-solid"
                                    placeholder="Isi agenda penugasan" name="agenda"></textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Jam Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="time" class="form-control form-control-solid"
                                    placeholder="Isi jam penjemputan" name="jam_penjemputan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tgl. Penjemputan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver dan kendaraan yang tersedia"></i>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Isi tanggal penjemputan" name="tgl_penjemputan" id="tgl_penjemputan" />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">
                                    <span class="required">Kendaraan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan kendaraan yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Kendaraan" id="id_kendaraan"
                                    name="id_kendaraan">
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">
                                    <span class="required">Driver</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Driver" id="id_driver"
                                    name="id_driver">
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kembali</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat kembali driver" name="tmp_kembali" />
                            </div>
                        </div>
                        <div class="form-group table-responsive d-flex mb-8 row">
                            <!--begin::Table-->
                            <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700" data-kt-element="items">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                        <th class="min-w-300px w-200px">Nama Penumpang</th>
                                        <th class="min-w-200px w-100px">Jabatan</th>
                                        <th class="min-w-200px w-100px">No. Tlp
                                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                                title="Pilih salah satu nomer penumpang untuk review"></i>
                                        </th>
                                        <th class="min-w-75px w-75px text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                        <td class="pe-7">
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control form-control-solid mb-2"
                                                    name="nama_penumpang[]" placeholder="Nama Penumpang" />
                                            </div>
                                        </td>
                                        <td class="ps-0">
                                            <input type="text" class="form-control form-control-solid"
                                                name="jbtn_penumpang[]" placeholder="Jabatan Penumpang" />
                                        </td>
                                        <td>
                                            <div class="form-check form-check-custom form-check-solid">
                                                {{-- <input class="form-check-input me-3" type="radio" value="y"
                                                    name="status[]" i /> --}}
                                                <input type="text" class="form-control form-control-solid"
                                                    name="no_tlp[]" placeholder="No. Telpon" />
                                            </div>
                                        </td>
                                        <td class="pt-5 text-end">
                                            <button type="button" class="btn btn-link py-1 btn-add-penumpang"
                                                data-kt-element="add-item">Tambah</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--begin::Item template-->
                            <table class="table d-none" data-kt-element="item-template">
                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                    <td class="pe-7">
                                        <input type="text" class="form-control form-control-solid mb-2"
                                            name="nama_penumpang[]" placeholder="Nama Penumpang" />
                                    </td>
                                    <td class="ps-0">
                                        <input type="text" class="form-control form-control-solid"
                                            name="jbtn_penumpang[]" placeholder="Jabatan Penumpang" />
                                    </td>
                                    <td>
                                        <div class="form-check form-check-custom form-check-solid">
                                            {{-- <input class="form-check-input me-3" type="radio" value="y"
                                                name="status[]" id="status" /> --}}
                                            <input type="text" class="form-control form-control-solid" name="no_tlp[]"
                                                placeholder="No. Telpon" />
                                        </div>
                                    </td>
                                    <td class="pt-5 text-end">
                                        <button type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                                            data-kt-element="remove-item">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <i class="bi bi-trash fs-1"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <table class="table d-none" data-kt-element="empty-template">
                                <tr data-kt-element="empty">
                                    <th colspan="5" class="text-muted text-center py-10">No items</th>
                                </tr>
                            </table>
                            <!--end::Item template-->
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
                            no_so: {
                                validators: {
                                    notEmpty: {
                                        message: "No. So Harus Diisi"
                                    }
                                }
                            },
                            tmp_tujuan: {
                                validators: {
                                    notEmpty: {
                                        message: "Tempat Tujuann Harus Diisi"
                                    }
                                }
                            },
                            tmp_penjemputan: {
                                validators: {
                                    notEmpty: {
                                        message: "Tempat Penjemputan Harus Diisi"
                                    }
                                }
                            },
                            agenda: {
                                validators: {
                                    notEmpty: {
                                        message: "Agenda Penugasan Harus Diisi"
                                    }
                                }
                            },
                            jam_penjemputan: {
                                validators: {
                                    notEmpty: {
                                        message: "Jam Penjemputan Harus Diisi"
                                    }
                                }
                            },
                            tgl_penjemputan: {
                                validators: {
                                    notEmpty: {
                                        message: "Tgl. Pejemputan Harus Diisi"
                                    }
                                }
                            },
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
                            tmp_kembali: {
                                validators: {
                                    notEmpty: {
                                        message: "Kembali Harus Diisi"
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
                            (a.reset(), window.location.href = "{{route('checking.serviceorder')}}") : "cancel" === t.dismiss && Swal.fire({
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

    var KTAppInvoicesCreate = function() {
        var e, t = function() {
                var t = [].slice.call(e.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]')),
                    a = 0;
            },
            a = function() {
                if (0 === e.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length) {
                    var t = e.querySelector('[data-kt-element="empty-template"] tr').cloneNode(!0);
                    e.querySelector('[data-kt-element="items"] tbody').appendChild(t)
                } else KTUtil.remove(e.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'))
            };
        return {
            init: function(n) {
                (e = document.querySelector("#kt_form_accept")).querySelector('[data-kt-element="items"] [data-kt-element="add-item"]').addEventListener("click", (function(n) {
                    n.preventDefault();
                    var l = e.querySelector('[data-kt-element="item-template"] tr').cloneNode(!0);
                    e.querySelector('[data-kt-element="items"] tbody').appendChild(l), a(), t()
                })), KTUtil.on(e, '[data-kt-element="items"] [data-kt-element="remove-item"]', "click", (function(e) {
                    e.preventDefault(), KTUtil.remove(this.closest('[data-kt-element="item"]')), a(), t()
                })),
                t()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTAppInvoicesCreate.init()
    }));

    $(function () {
        // $('.btn-cancel').each(function () {
        //     // var id = $(this).data('id');
        //     $(this).attr("checked",function () {
        //         console.log('checked')
        //     });
        // });
        $('#tgl_penjemputan').on('change', function () {
            var tgl_penjemputan = $(this).val();
            console.log(tgl_penjemputan);
            $.ajax({
                url : '{{route("driver.select")}}',
                method : 'GET',
                data : {
                    'tgl_penjemputan' : $(this).val()
                },
                dataType : 'json',
                success : function (result) {
                    console.log(result);
                    console.log(result.Success);
                    console.log(result.Kendaraan);
                    console.log(result.Driver);
                    if (result.Success == true) {
                        $('#id_driver').empty();
                        $('#id_kendaraan').empty();
                        var kendaraan = result.Kendaraan;
                        var driver = result.Driver;
                        $.each(kendaraan, function (key, item) {
                            $('#id_kendaraan').append($('<option></option>').attr('value', item.id_kendaraan).text(item.no_polisi+' | '+item.nama_kendaraan+' | '+item.alokasi));
                                // $('option', this).each(function () {
                                //     if ($(this).html() == item.nama_driver) {
                                //         $(this).attr('selected', 'selected')
                                //     };
                                // });
                        });
                        $.each(driver, function (key, item) {
                            $('#id_driver').append($('<option></option>').attr('value', item.id_driver).text(item.nama_driver));
                                // $('option', this).each(function () {
                                //     if ($(this).html() == item.nama_driver) {
                                //         $(this).attr('selected', 'selected')
                                //     };
                                // });
                        })
                    } else {
                        alert(result.Message);
                        $('#id_driver').empty();
                        $('#id_kendaraan').empty();
                    }
                }
            });
        });
    });
</script>
@endpush
