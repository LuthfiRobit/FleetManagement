@extends('layouts.backend.main')

@section('title','Pengajuan Pembatalan Tugas | Detail')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL PEMBATALAN TUGAS</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Driver : {{$driver->nama_driver}}</span>
                    </h3>
                </div>
            </div>
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
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
                            <h5 class="mb-1">Success</h5>
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
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">LAPORAN PEMBATALAN</h2>
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                @if ($batal->status_pembatalan == 't')
                                <div class=" bg-light-primary rounded border-primary border border-dashed p-2">
                                    DITERIMA
                                </div>
                                @elseif ($batal->status_pembatalan == 'tl')
                                <div class=" bg-light-danger rounded border-danger border border-dashed p-2">
                                    DITOLAK
                                </div>
                                @else
                                {{-- <div class="card-toolbar"> --}}
                                    <!--begin::Add-->
                                    <button type="button" class="btn btn-light-primary btn-sm"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </span>Respon
                                        <!--end::Svg Icon-->
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_terima">Terima Pembatalan</a>
                                            {{-- <a href="#" class="menu-link px-3" id="modal_accept"">Accept</a> --}}
                                     </div>
                                     <!--end::Menu item-->
                                     <!--begin::Menu item-->
                                     <div class=" menu-item px-3">
                                                <a type="button" class="menu-link px-3" id="kt_modal_tolak">Tolak
                                                    Pembatalan</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                    <!--end::Add-->
                                    {{--
                                </div> --}}
                                @endif

                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">No. DO:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a
                                                        href="{{route('assign.detail',$batal->id_do)}}">DO_{{$batal->no_so}}</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Driver:</td>
                                                <td class="text-gray-800 min-w-200px">{{$driver->nama_driver}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tanggal Pembatalan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($batal->tanggal)->format('d F Y')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Status:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($batal->status_pembatalan == 't')
                                                    <div class="badge badge-lg badge-light-primary d-inline">
                                                        DITERIMA
                                                    </div>
                                                    @elseif ($batal->status_pembatalan == 'tl')
                                                    <div class=" badge badge-lg badge-light-danger d-inline">
                                                        DITOLAK
                                                    </div>
                                                    @else
                                                    <div class=" badge badge-lg badge-light-warning d-inline">
                                                        BUTUH RESPON
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Alasan:</td>
                                                <td class="text-gray-800">{{$batal->alasan}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Bukti:</td>
                                                <td class="text-gray-800">
                                                    <div
                                                        class="col text-center bg-light-primary rounded border-primary border border-dashed">
                                                        <!--begin::Overlay-->
                                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                                            href="{{url('/assets/img_batal/'.$batal->bukti)}}">
                                                            <!--begin::Image-->
                                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                                style="background-image:url('{{url('/assets/img_batal/'.$batal->bukti)}}')">
                                                            </div>
                                                            <!--end::Image-->
                                                            <!--begin::Action-->
                                                            <div
                                                                class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                                <i class="bi bi-eye-fill fs-2x text-white"></i>
                                                            </div>
                                                            <!--end::Action-->
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Row-->
                            </div>
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
                                <h2>DRIVER</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div
                                        class="symbol symbol-60px symbol-circle me-3 border-primary border border-dashed">
                                        <img alt="Pic" @if ($driver->foto_driver != null)
                                        src="{{url('assets/img_driver/'.$driver->foto_driver)}}"
                                        @else
                                        src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                        @endif
                                        />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-2">
                                            {{$driver->nama_driver}}
                                        </a>
                                        <!--end::Name-->
                                        <!--begin::Email-->
                                        <a href="#"
                                            class="fw-bold text-gray-600 text-hover-primary">{{$driver->no_tlp}}</a>
                                        <!--end::Email-->
                                        <span class="badge badge-light-primary">{{$driver->departemen}}</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-400">History Pembatalan:</td>
                                    <td class="text-gray-800">{{$history}} kali</td>
                                </tr>
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-400">Pembatalan Diterima:</td>
                                    <td class="text-gray-800">{{$terima}} kali
                                    </td>
                                </tr>
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-400">Pembatalan Ditolak:</td>
                                    <td class="text-gray-800">{{$tolak}} kali</td>
                                </tr>
                            </table>
                            <!--end::Section-->
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

    <!--begin::Modal - New Target-->
    <div class="modal fade" id="kt_modal_terima" tabindex="-1" aria-hidden="true">
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
                    <form id="kt_modal_terima_form" class="form" action="{{route('assign.batal.terima')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Persetujuan Pembatalan Tugas Driver</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="text-muted fw-bold fs-5">Silahkan lakukan penggantian driver
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>No. DO</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid" value="DO_{{$batal->no_so}}"
                                    disabled />
                                <input type="hidden" name="id_pembatalan" value="{{$batal->id_pembatalan}}">
                                <input type="hidden" name="id_do" value="{{$batal->id_do}}">
                            </div>
                            <div class="col-lg-6">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>Kendaraan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    value="DO_{{$batal->nama_kendaraan}} | {{$batal->no_polisi}} | {{$batal->nama_sim}}"
                                    disabled />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span>Driver Lama</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    value="{{$driver->nama_driver}}" disabled />
                            </div>
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Driver Baru</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Driver" id="id_driver_baru"
                                    name="id_driver_baru">
                                    @foreach ($drivers as $dr)
                                    <option value="{{$dr->id_driver}}" {{$dr->id_driver == $batal->id_driver ?
                                        'disabled' : ''}} >{{$dr->nama_driver}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_terima_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_terima_submit" class="btn btn-primary">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon Tunggu...
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

<script text="text/javascript">
    "use strict";
    var KTModalNewTarget = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_terima")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_terima_form"),
                    t = document.getElementById("kt_modal_terima_submit"),
                    e = document.getElementById("kt_modal_terima_cancel")
                    , n = FormValidation.formValidation(a, {
                        fields: {
                            id_driver_baru: {
                                validators: {
                                    notEmpty: {
                                        message: "Driver Baru Harus Dipilih!"
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
                                    text: "Pembatalan Berhasil Disimpan!",
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
                            t.value ? (a.reset(), o.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Form Anda belum dibatalkan!.",
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

    var KTUModalTolak = {
        init: function () {
            document.getElementById("kt_modal_tolak").addEventListener("click", (t => {
                t.preventDefault(), Swal.fire({
                    // text: "Apakah anda yakin menolak pembatalan tugas dari ?",
                    html: "Apakah anda yakin menolak pembatalan tugas dari <strong>{{$driver->nama_driver}}</strong> ? <br>"+
                    " <strong>{{$driver->nama_driver}}</strong> bisa melakukan pembatalan kembali.",
                    icon: "warning",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Ya, tolak !",
                    cancelButtonText: "Tidak, Kembali",
                    preConfirm: function(result) {
                        window.location.href = "{{route('assign.batal.tolak',$batal->id_pembatalan)}}";
                        // $.ajax({
                        //     type: 'POST',
                        //     url: "{{route('assign.batal.tolak',$batal->id_pembatalan)}}",
                        //     data: {
                        //         '_token': '{{csrf_token()}}',
                        //     },
                        //     datatype: 'JSON',
                        //     success: function (response) {
                        //         console.log(response);
                        //     },
                        //     error: function (response) {
                        //         console.log(response);
                        //     }
                        // });
                    },
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }

                }).then((function (t) {
                    t.value ? Swal.fire({
                        // text: "You have removed this two-step authentication!.",
                        html:"Anda sudah menolak pembatalan tugas dari <strong>{{$driver->nama_driver}}</strong>",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }) : "cancel" === t.dismiss && Swal.fire({
                        text: "Anda membatalkan penolakan!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }))
            }))
        }
    };
    KTUtil.onDOMContentLoaded((function () {
        KTUModalTolak.init()
    }));
</script>
@endpush
