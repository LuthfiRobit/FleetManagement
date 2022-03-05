@extends('layouts.backend.main')

@section('title','Service Order | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL SERVICE ORDER</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Dipesan Oleh : {{$serviceorder->nama_lengkap}}</span>
                    </h3>
                </div>
            </div>
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">SERVICE ORDER</h2>
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                @if ($serviceorder->status_so == 't')
                                <span class="badge badge-light-primary">Diterima</span>
                                @elseif($serviceorder->status_so == 'tl')
                                <span class="badge badge-light-danger">Ditolak</span>
                                @else
                                <!--begin::Add-->
                                <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                    <!--end::Svg Icon-->Aksi
                                </button>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{route('checking.serviceorder.accept.form', $serviceorder->id_service_order)}}"
                                            class="menu-link px-3">Terima</a>
                                        {{-- <a href="#" class="menu-link px-3" id="modal_accept"">Accept</a> --}}
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class=" menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_reject">Tolak</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Add-->
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
                                                <td class="text-gray-400 min-w-175px w-175px">No. So:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary">SO_{{$serviceorder->id_service_order}}</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tanggal Penjemputan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($serviceorder->tgl_penjemputan)->format('d F
                                                    Y')}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Jam Penjemputan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($serviceorder->jam_penjemputan)->format('H:i')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tempat Penjemputan:</td>
                                                <td class="text-gray-800">{{$serviceorder->tempat_penjemputan}}
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
                                                <td class="text-gray-400 min-w-175px w-175px">Tempat Tujuan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    {{$serviceorder->tujuan}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tujuan Perjalanan:</td>
                                                <td class="text-gray-800">
                                                    {{$serviceorder->keterangan}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Status:</td>
                                                <td class="text-gray-800">
                                                    @if ($serviceorder->status_so == 't')
                                                    <span class="badge badge-light-primary">Diterima</span>
                                                    @elseif($serviceorder->status_so == 'tl')
                                                    <span class="badge badge-light-danger">Ditolak</span>
                                                    @else
                                                    <span class="badge badge-light-warning">Butuh Direspon</span>
                                                    @endif
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
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Penumpang:</h5>
                                <!--end::Title-->
                                <!--begin::Product table-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                        <!--begin::Table head-->
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Nama</th>
                                                <th>Jabatan</th>
                                                <th class="min-w-125px">No. Tlp</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach ($detailso as $ds)
                                            <tr>
                                                <td>{{$ds->nama_penumpang}}</td>
                                                <td>{{$ds->nama_jabatan}}</td>
                                                <td>{{$ds->no_tlp}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Product table-->
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
                        data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{default: false}"
                        data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="true"
                        data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>PEMESAN</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Nama Pemesan:</td>
                                        <td class="text-gray-800">{{$order->nama_lengkap}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Jabatan:</td>
                                        <td class="text-gray-800">{{$order->nama_jabatan}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Departemen:</td>
                                        <td class="text-gray-800">{{$order->nama_departemen}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">No. Tlp:</td>
                                        <td class="text-gray-800">{{$order->no_tlp}}</td>
                                    </tr>
                                    <!--end::Row-->
                                </table>
                                <!--end::Details-->
                            </div>
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
    <!--end::Post-->


    <!--begin::Modal - Reject-->
    <div class="modal fade" id="kt_modal_accept" tabindex="-1" aria-hidden="true">
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
                    <form id="kt_modal_accept_form" class="form"
                        action="{{route('checking.serviceorder.accept', $serviceorder->id_service_order)}}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Accept Service Order</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Driver</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Choose Driver" id="id_driver"
                                    name="id_driver">
                                    <option value="">Choose Driver</option>
                                    @foreach ($driver as $dr)
                                    <option value="{{$dr->id_driver}}">{{$dr->nama_driver}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Transportation</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Choose Transportation" id="id_kendaraan"
                                    name="id_kendaraan">
                                    <option value="">Choose Transportation</option>
                                    @foreach ($kendaraan as $kd)
                                    <option value="{{$kd->id_kendaraan}}">{{$kd->nama_kendaraan}} | {{$kd->no_polisi}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Return To</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Specify Return To"></i>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Type Return To"
                                name="kembali" />
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_accept_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_modal_accept_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
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
    <!--end::Modal - Reject-->

    <!--begin::Modal - Reject-->
    <div class="modal fade" id="kt_modal_reject" tabindex="-1" aria-hidden="true">
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
                    <form id="kt_modal_reject_form" class="form"
                        action="{{route('checking.serviceorder.reject', $serviceorder->id_service_order)}}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Tolak Service Order</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Deskripsi Penolakan</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Jelaskan Penolakan Service Order"></i>
                            </label>
                            <!--end::Label-->
                            <textarea name="keterangan_penolakan" class="form-control form-control-solid"
                                placeholder="Tuliskan Deskripsi Penolakan"></textarea>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_reject_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_reject_submit" class="btn btn-primary">
                                <span class="indicator-label">Kirim</span>
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
    <!--end::Modal - Reject-->

</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";
    // var KTModalAccepted = function () {
    //     var t, e, n, a, o, i;
    //     return {
    //         init: function () {
    //             (t = document.getElementById("modal_accept"),
    //             t.addEventListener("click", (function(t) {
    //                 t.preventDefault();
    //                 // const n = t.target.closest("tr"),
    //                 //     r = n.querySelectorAll("td")[1].querySelectorAll("a")[1].innerText;
    //                 Swal.fire({
    //                     text: "Are you sure you want to accept this service order ?",
    //                     icon: "warning",
    //                     showCancelButton: !0,
    //                     buttonsStyling: !1,
    //                     confirmButtonText: "Yes, accept!",
    //                     cancelButtonText: "No, cancel",
    //                     customClass: {
    //                         confirmButton: "btn fw-bold btn-primary",
    //                         cancelButton: "btn fw-bold btn-active-light-secondary"
    //                     }
    //                 }).then((function(t) {
    //                     t.value ? Swal.fire({
    //                         text: "You have accepted !.",
    //                         icon: "success",
    //                         buttonsStyling: !1,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn fw-bold btn-primary"
    //                         }
    //                     }).then((function() {
    //                         // e.row($(n)).remove().draw()
    //                         window.location.href = "{{ route('checking.serviceorder.accept',$serviceorder->id_service_order)}}"
    //                     })).then((function() {
    //                         // a()
    //                         // alert('aksi')
    //                         // window.location.href = "{{ route('checking.serviceorder.accept',$serviceorder->id_service_order)}}"
    //                     })) : "cancel" === t.dismiss && Swal.fire({
    //                         text: "Service order was not accepted.",
    //                         icon: "error",
    //                         buttonsStyling: !1,
    //                         confirmButtonText: "Ok, got it!",
    //                         customClass: {
    //                             confirmButton: "btn fw-bold btn-primary"
    //                         }
    //                     })
    //                 }))
    //             }))
    //             )
    //         }
    //     }
    // }();
    // KTUtil.onDOMContentLoaded((function () {
    //     KTModalAccepted.init()
    // }));


    var KTModalAccept = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_accept")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_accept_form"),
                    t = document.getElementById("kt_modal_accept_submit"),
                    e = document.getElementById("kt_modal_accept_cancel"),
                    n = FormValidation.formValidation(a, {
                        fields: {
                            id_driver: {
                                validators: {
                                    notEmpty: {
                                        message: "Driver Should be exist"
                                    }
                                }
                            },
                            id_kendaraan: {
                                validators: {
                                    notEmpty: {
                                        message: "Transportation Should be exist"
                                    }
                                }
                            },
                            kembali: {
                                validators: {
                                    notEmpty: {
                                        message: "Return To Should be exist"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }),
                    t.addEventListener("click", (function (e) {
                        e.preventDefault(), n && n.validate().then((function (e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Acception is Submite!",
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
                                text: "Sorry, Errors Detected",
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
                            text: "Are You Sure to Cancel It?",
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
                                text: "Your Rejection Hasn't been Canceled!.",
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
        KTModalAccept.init()
    }));

    var KTModalNewTarget = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_reject")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_reject_form"),
                    t = document.getElementById("kt_modal_reject_submit"),
                    e = document.getElementById("kt_modal_reject_cancel"),
                    n = FormValidation.formValidation(a, {
                        fields: {
                            keterangan_penolakan: {
                                validators: {
                                    notEmpty: {
                                        message: "Rejection Reason Should be exist"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 255,
                                        message: "Maximum character 255"
                                        // }
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }),
                    t.addEventListener("click", (function (e) {
                        e.preventDefault(), n && n.validate().then((function (e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Rejection is Submiter!",
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
                                text: "Sorry, Errors Detected",
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
                            text: "Are You Sure to Cancel It?",
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
                                text: "Your Rejection Hasn't been Canceled!.",
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
