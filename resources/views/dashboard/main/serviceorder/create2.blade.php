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
                            <input type="hidden" value="{{$last_so->id_service_order+1}}" name="id_service_order" />
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">No. SO</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" placeholder="Isi No. So"
                                    name="no_so" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tujuan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat tujuan" name="tmp_tujuan" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat penjemputan" name="tmp_penjemputan" required />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Agenda</span>
                                </label>
                                <!--end::Label-->
                                <textarea type="text" class="form-control form-control-solid"
                                    placeholder="Isi agenda penugasan" name="agenda" required></textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Jam Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="time" class="form-control form-control-solid"
                                    placeholder="Isi jam penjemputan" name="jam_penjemputan" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tgl. Penjemputan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver dan kendaraan yang tersedia"></i>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Isi tanggal penjemputan" name="tgl_penjemputan" id="tgl_penjemputan"
                                    required />
                            </div>
                        </div>
                        <div class="form-group mb-8 row">
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">
                                    <span class="required">Kendaraan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan kendaraan yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Kendaraan" id="id_kendaraan"
                                    name="id_kendaraan" required>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="required fs-6 fw-bold mb-2">
                                    <span class="required">Driver</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Driver" id="id_driver"
                                    name="id_driver" required>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kembali</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat kembali driver" name="tmp_kembali" required />
                            </div>
                            <div class="col-lg-2">
                                <label class="d-flex fs-6 fw-bold mb-2">
                                    <span class="required">Jumlah Penumpang</span>
                                </label>
                                <!--end::Label-->
                                <input type="number" class="form-control form-control-solid"
                                    placeholder="Isi jumlah penumpang" name="jml_penumpang" id="jml_penumpang"
                                    required />
                            </div>
                        </div>
                        <div class="isi form-group d-flex mb-8 row">
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
    // var KTFormAccept = function () {
    //     var t, e, n, a, i;
    //     return {
    //         init: function () {
    //             (
    //                 a = document.querySelector("#kt_form_accept"),
    //                 t = document.getElementById("kt_button_submit"),
    //                 e = document.getElementById("kt_button_cancel")
    //                 , n = FormValidation.formValidation(a, {
    //                     fields: {
    //                         no_so: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "No. So Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         tmp_tujuan: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Tempat Tujuann Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         tmp_penjemputan: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Tempat Penjemputan Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         agenda: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Agenda Penugasan Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         jam_penjemputan: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Jam Penjemputan Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         tgl_penjemputan: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Tgl. Pejemputan Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         id_kendaraan: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Kendaraan Harus Dipilih"
    //                                 }
    //                             }
    //                         },
    //                         id_driver: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Driver Harus Dipilih"
    //                                 }
    //                             }
    //                         },
    //                         tmp_kembali: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Kembali Harus Diisi"
    //                                 }
    //                             }
    //                         },
    //                         jml_penumpang: {
    //                             validators: {
    //                                 notEmpty: {
    //                                     message: "Jumlah Penumpang Harus Diisi"
    //                                 }
    //                             }
    //                         }
    //                         // nama_pe: {
    //                         //     validators: {
    //                         //         notEmpty: {
    //                         //             message: "Kembali Harus Diisi"
    //                         //         }
    //                         //     }
    //                         // }
    //                     },
    //                     plugins: {
    //                         trigger: new FormValidation.plugins.Trigger,
    //                         bootstrap: new FormValidation.plugins.Bootstrap5({
    //                             rowSelector: ".row",
    //                             // eleInvalidClass: "",
    //                             // eleValidClass: ""
    //                         })
    //                     }
    //                 }),
    //                 t.addEventListener("click", (function (e) {
    //                     e.preventDefault(), n && n.validate().then((function (e) {
    //                         console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
    //                             t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
    //                                 text: "Formulir telah berhasil dikirim!",
    //                                 icon: "success",
    //                                 buttonsStyling: !1,
    //                                 confirmButtonText: "Ok, mengerti!",
    //                                 customClass: {
    //                                     confirmButton: "btn btn-primary"
    //                                 }
    //                             }).then((function (t) {
    //                                 a.submit()
    //                                 t.isConfirmed && o.hide()
    //                             }))
    //                         }), 2e3)) : Swal.fire({
    //                             text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
    //                             icon: "error",
    //                             buttonsStyling: !1,
    //                             confirmButtonText: "Ok, mengerti!",
    //                             customClass: {
    //                                 confirmButton: "btn btn-primary"
    //                             }
    //                         })
    //                     }))
    //                 })),
    //                 e.addEventListener("click", (function (t) {
    //                     t.preventDefault(), Swal.fire({
    //                         text: "Apakah Anda yakin ingin membatalkan?",
    //                         icon: "warning",
    //                         showCancelButton: !0,
    //                         buttonsStyling: !1,
    //                         confirmButtonText: "Ya, batalkan!",
    //                         cancelButtonText: "Tidak, kembali",
    //                         customClass: {
    //                             confirmButton: "btn btn-primary",
    //                             cancelButton: "btn btn-active-light"
    //                         }
    //                     }).then((function (t) {

    //                         t.value ?
    //                         (a.reset(), window.location.href = "{{route('checking.serviceorder')}}") : "cancel" === t.dismiss && Swal.fire({
    //                             text: "Formulir Anda belum dibatalkan!.",
    //                             icon: "error",
    //                             buttonsStyling: !1,
    //                             confirmButtonText: "Ok, mengerti!",
    //                             customClass: {
    //                                 confirmButton: "btn btn-primary"
    //                             }
    //                         })
    //                     }))
    //                 }))
    //             )
    //         }
    //     }
    // }();
    // KTUtil.onDOMContentLoaded((function () {
    //     KTFormAccept.init()
    // }));

    $(function () {
        $('#jml_penumpang').on('change', function () {
            var a = $(this).val();
            $('.isi').empty();
            var j = 1;
            for (let i = 0; i < a; i++) {
                console.log(i);
                $('.isi').append(
                // '<p><input name="name_ct[]" id="id_ct' + j + '" type="text" class="form-control" placeholder="Add Variant ' + j + ' Name " ></p>'+
                '<div class="form-group d-flex mb-8 row pen">'+
                    '<div class="col-lg-4">'+
                        // '<label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Penumpang</span><i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Sesuaikan nama penumpang></i></label>'+
                        '<input type="text" class="form-control form-control-solid" placeholder="Nama penumpang '+j+'" name="nama_penumpang[]" id="nama_'+i+'" required/>'+
                    '</div>'+
                    '<div class="col-lg-2">'+
                        // '<label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Penumpang</span><i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Sesuaikan nama penumpang></i></label>'+
                        // '<input class="form-check-input mt-2 ps-2" type="radio" name="status[]" id="status" required/>'+
                        // '<select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Pilih Status" name="status[]">'+
                            // '<option value="">Pilih Status</option>'+
                            // '<option value="n">Penumpang</option>'+
                            // '<option value="y">Lead</option>'+
                        // '</select>'+
                        // '<label class="form-check form-switch form-switch-md form-check-custom form-check-solid flex-stack mb-5">'+
                            // '<span class="form-check-label ms-0 fw-bolder fs-6 text-gray-700">Payment method</span>'
                            '<input class="form-check-input" type="checkbox" name="status['+i+']" id="status_'+i+'" value="y" required>'+
                        // '</label>'+
                        // '<div class="radio-inline">'+
                        //     '<label class="radio radio-square">'+
                        //         '<input class="form-check-input mt-2 ps-2" type="radio" value="y" name="status_y[]">'+
                        //         '<span>Lead</span>'+
                        //     '</label>'+
                        //     '<label class="radio radio-square">'+
                        //         '<input class="form-check-input mt-2 ps-2" type="radio" checked="checked" value="n" name="status[]">'+
                        //         '<span>Pess</span>'+
                        //     '</label>'+
                        // '</div>'+
                    '</div>'+
                    '<div class="col-lg-3">'+
                        // '<label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Penumpang</span><i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Sesuaikan nama penumpang></i></label>'+
                        '<input type="text" class="form-control form-control-solid no-tlp-penumpang" placeholder="No. Tlpn penumpang '+j+', [6285...]" id="no_tlp_'+i+'" name="no_tlp[]" maxlength="13" required/>'+
                    '</div>'+
                    '<div class="col-lg-3">'+
                        // '<label class="d-flex align-items-center fs-6 fw-bold mb-2"><span class="required">Nama Penumpang</span><i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Sesuaikan nama penumpang></i></label>'+
                        ' <input type="text" class="form-control form-control-solid" name="jbtn_penumpang[]" placeholder="Jabatan Penumpang '+j+'" required/>'+
                    '</div>'+
                '</div>'
                );
                $('#no_tlp_'+i+'').on('change', function () {
                    var letter = $(this).val();
                    var replace;
                    if (letter[0] == '0') {
                        replace = letter.replace(letter[0], '62');
                    } else {
                        replace =  $(this).val();
                    }
                    console.log(replace);
                    $(this).val(replace);
                });

                $('input[type="checkbox"]').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('input[type=checkbox]').attr('disabled', true);
                        $(this).attr('disabled', false);
                        console.log($(this).val("y"));
                        // $(this).closest("div.pen").find("input[name=nama_penumpang]").val("n");

                        // $('#customdelimiter').val($(this).val());
                    } else {
                        $('input[type=checkbox]').attr('disabled', false);
                        // $('#customdelimiter').val('');
                    }
                    // console.log(replace)
                    // if($(this).attr('checked')){
                    //     $(this).val('y');
                    // }else{
                    //     $(this).val('t');
                    // }
                    // $(this).val(this.checked ? "y" : "t");
                    // $('input[type="checkbox"]').not(this).prop('checked', false);
                    // $('input[type="checkbox"]').not(this).prop('required', false);
                    // $('input[type="checkbox"]').not(this).val('t');  
                    // console.log( $(this).val());
                    // var input = $('[name="nama_penumpang"]');
                    // if ($(this).is(":checked")) {
                    //     input.val("y");
                    //     input.not(this).val("t");
                    // } else {
                    //     input.val("t");
                    // }
                });
                // $('input[type="select"]').on('change', function() {
                //     $('input[type="checkbox"]').not(this).val('t');
                // });

                j++;
            }
        });

       
        $('.no-tlp-penumpang').each(function () {
            var letter = $(this).value[0]
            $(this).on('change', function () {
                alert(letter);
            });
        })

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
                        var alokasi;
                        $.each(kendaraan, function (key, item) {
                            if (item.alokasi == null) {
                                alokasi = '---';
                            } else {
                                alokasi = item.alokasi;
                            }
                            $('#id_kendaraan').append($('<option></option>').attr('value', item.id_kendaraan).text(item.no_polisi+' | '+item.nama_kendaraan+' | '+alokasi));
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
