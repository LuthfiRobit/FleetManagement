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
                        <span class="card-label fw-bolder fs-3 mb-1">Detail Service Order</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Dipesan Oleh : {{$serviceorder->nama_lengkap}}</span>
                    </h3>
                </div>
            </div>
            <!--begin:: Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--end:: sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->
                            <!--begin::User Info-->
                            <div class="d-flex flex-center flex-column py-5">
                                <!--begin::Name-->
                                <a href="#"
                                    class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$order->nama_lengkap}}</a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="mb-9">
                                    <!--begin::Badge-->
                                    <div class="badge badge-lg badge-light-primary d-inline">
                                        {{$order->nama_departemen}}
                                    </div>
                                    <!--begin::Badge-->
                                </div>
                                <!--end::Position-->
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bolder rotate collapsible collapsed">Penumpang
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" title=""
                                    data-bs-original-title="Edit customer details">
                                    <a class="btn btn-sm btn-light-primary">{{$jumlahdetail}}</a>
                                </span>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details">
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed gy-5"
                                        id="kt_table_users_login_session">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Nama</th>
                                                <th>No. Telepon</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach ($detailso as $ds)
                                            <tr>
                                                <td>{{$ds->nama_penumpang}}</td>
                                                <td>{{$ds->no_tlp}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:: sidebar-->
                <!--begin:: content-->
                <div class="flex-lg-row-fluid ms-lg-15" id="kt_table_users">
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">ID Service Order</h2>
                                <div class="fs-6 fw-bold text-muted">SO_{{$serviceorder->id_service_order}}</div>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
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
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mt-2">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-primary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-7 fw-bolder text-dark text-hover-primary">Tanggal dan Jam
                                        Penjemputan</a>
                                    <!--begin::Info-->
                                    <div class="fs-5 text-muted">
                                        {{Carbon\Carbon::parse($serviceorder->tgl_penjemputan)->format('d F Y')}} |
                                        {{Carbon\Carbon::parse($serviceorder->jam_penjemputan)->format('H:i')}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mt-2">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-7 fw-bolder text-dark text-hover-primary">Tempat Penjemputan</a>
                                    <!--begin::Info-->
                                    <div class="fs-5 text-muted">{{$serviceorder->tempat_penjemputan}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mt-2">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-primary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-7 fw-bolder text-dark text-hover-primary">Tempat Tujuan</a>
                                    <!--begin::Info-->
                                    <div class="fs-5 text-muted">{{$serviceorder->tujuan}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mt-2">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-7 fw-bolder text-dark text-hover-primary">Tujuan Keberangkatan</a>
                                    <!--begin::Info-->
                                    <div class="fs-5 text-muted">{{$serviceorder->keterangan}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
                <!--end:: content-->
            </div>
            <!--begin:: Layout-->
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
