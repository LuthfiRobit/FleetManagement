@extends('layouts.backend.main')

@section('title','Vehicle Check | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">Detail Vechile Check</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Checked By : {{$pengecekan->nama_driver}}</span>
                    </h3>
                </div>
            </div>

            @if(session()->has('success'))
            <!--begin::Alert-->
            <div
                class="alert alert-dismissible bg-light-primary border border-primary border-dashed d-flex flex-column flex-sm-row w-100 p-5 mb-10">
                <!--begin::Icon-->
                <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-primary me-4 mb-5 mb-sm-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
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
                                    class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$pengecekan->nama_kendaraan}}</a>
                                <!--end::Name-->
                            </div>
                            <div class="d-flex flex-wrap flex-center">
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span class="w-75px">{{$pengecekan->kode_asset}}</span>
                                    </div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span class="w-75px">{{$pengecekan->no_polisi}}</span>
                                    </div>
                                </div>
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bolder rotate collapsible collapsed">Detail Vehicle
                                </div>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details">
                                <div class="pb-5 fs-6">
                                    <div class="fw-bolder mt-5">Latest Kilometers</div>
                                    <div class="text-gray-600">{{$pengecekan->km_kendaraan}} Km</div>
                                    <div class="fw-bolder mt-5">Merk</div>
                                    <div class="text-gray-600">{{$pengecekan->merk}} </div>
                                    <div class="fw-bolder mt-5">Type</div>
                                    <div class="text-gray-600">{{$pengecekan->jenis}}</div>
                                    <div class="fw-bolder mt-5">Fuel</div>
                                    <div class="text-gray-600">{{$pengecekan->bahan_bakar}}</div>
                                    <div class="fw-bolder mt-5">Color</div>
                                    <div class="text-gray-600">{{$pengecekan->warna}}</div>
                                    <div class="fw-bolder mt-5">Drive Type</div>
                                    <div class="text-gray-600">{{$pengecekan->jenis_penggerak}}</div>
                                </div>
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
                                <h2 class="mb-1">ID Vehicle Check</h2>
                                <div class="fs-6 fw-bold text-muted">VC_{{$pengecekan->id_pengecekan}} |
                                    @if($pengecekan->status_pengecekan == 'c')
                                    <span class="badge badge-light-success">Normal Check</span>
                                    @else
                                    <span class="badge badge-light-warning">Accident check</span>
                                    @endif
                                </div>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Add-->
                                <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>
                                    <!--end::Svg Icon-->Actions
                                </button>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_repair">Repair</a>
                                        {{-- <a href="#" class="menu-link px-3" id="modal_accept"">Accept</a> --}}
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu item-->
                                 <div class=" menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_reject">Update Repairation</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Add-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Checking Date and
                                        Time</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{Carbon\Carbon::parse($pengecekan->tgl_pengecekan)->format('d F Y')}} |
                                        {{Carbon\Carbon::parse($pengecekan->jam_pengecekan)->format('H:i')}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed gy-5"
                                    id="kt_table_users_login_session">
                                    <!--begin::Table head-->
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                        <!--begin::Table row-->
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th class="min-w-100px">Criteria</th>
                                            <th>Type</th>
                                            <th>Condition</th>
                                            <th class="min-w-125px">Description</th>
                                        </tr>
                                        <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        @foreach ($detail as $dp)
                                        <tr>
                                            <td>{{$dp->kriteria}}</td>
                                            <td>{{$dp->jenis}}</td>
                                            <td>
                                                @if($dp->kondisi == 'b')
                                                <span class="badge badge-light-success">Normal</span>
                                                @else
                                                <span class="badge badge-light-danger">Damaged</span>
                                                @endif
                                            </td>
                                            <td>{{$dp->keterangan}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
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

    <!--begin::Modal Repair-->
    <div class="modal fade" id="kt_modal_repair" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-1000px">
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
                    <form id="kt_modal_repair_form" class="form" action="{{route('repair.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- @method('POST') --}}
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Repairation Approval</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="form-group d-flex mb-8 row" id="id_approval">
                            <div class="col-lg-3">
                                <label class="required fs-6 fw-bold mb-2">Checking ID</label>
                                <input type="text" class="form-control form-control-solid"
                                    value="VC_{{$pengecekan->id_pengecekan}}" disabled />
                                <input type="hidden" class="form-control form-control-solid"
                                    value="{{$pengecekan->id_pengecekan}}" name="id_pengecekan" />
                            </div>
                            <div class="col-lg-3">
                                <label class="required fs-6 fw-bold mb-2">Approval Date</label>
                                <input type="date" class="form-control form-control-solid" name="tgl_persetujuan"
                                    id="tgl_persetujuan" value="{{date('Y-m-d')}}" />
                            </div>
                            <div class="col-lg-3">
                                <label class="required fs-6 fw-bold mb-2">No. Work Order</label>
                                <input type="number" class="form-control form-control-solid" name="no_wo" id="no_wo" />
                            </div>
                            <div class="col-lg-3">
                                <label class="required fs-6 fw-bold mb-2">Acception</label>
                                <div class="form-check form-switch form-check-custom form-check-solid me-10">
                                    <input class="form-check-input h-40px w-60px" type="checkbox" value="t" id="status"
                                        name="status" onclick="statusCheck()" />
                                    <input type="hidden" class="form-control form-control-solid" name="req_status"
                                        id="req_status" value="t" />
                                    <label class="form-check-label" id="status_name">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group  mb-8 row" id="id_reparation" hidden>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Choose Dealer</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Choose Dealer" id="id_dealer"
                                    name="id_dealer">
                                    <option value="">Choose Dealer</option>
                                    @foreach ($dealer as $dl)
                                    <option value="{{$dl->id_dealer}}">
                                        {{$dl->nama_dealer}} |
                                        @if ($dl->status_dealer == 'p')
                                        <span class="badge badge-light-primary">Private</span>
                                        @else
                                        <span class="badge badge-light-danger">Partner</span>
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Start at Date</label>
                                <input type="date" class="form-control form-control-solid" name="tgl_perbaikan"
                                    id="tgl_perbaikan" value="{{date('Y-m-d')}}" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Due Date</label>
                                <input type="date" class="form-control form-control-solid" name="tgl_perbaikan"
                                    id="tgl_selesai" />
                            </div>
                        </div>
                        <div class="form-group  mb-8 row" id="id_components" hidden>
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th>Components</th>
                                            <th>Condition</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        @foreach ($detail as $dp)
                                        <tr>
                                            <td>{{$dp->jenis}}</td>
                                            <td>
                                                @if($dp->kondisi == 'b')
                                                <span class="badge badge-light-success">Normal</span>
                                                @else
                                                <span class="badge badge-light-danger">Damaged</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_repair_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_modal_repair_submit" class="btn btn-primary">
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
    <!--end::Modal Repair-->

</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";
    function statusCheck() {
    var checkBox = document.getElementById("status");
    var status = document.getElementById("req_status");
    var text = document.getElementById("status_name");
    var reparation = document.getElementById("id_reparation");
    var component = document.getElementById("id_components");
        if (checkBox.checked == true){
            text.style.display = "block";
            text.innerText = "Accepted";
            reparation.removeAttribute('hidden');
            component.removeAttribute('hidden');
            status.setAttribute('value', 's');
            // reparation.setAttribute('hidden', false);
            // component.setAttribute('hidden', false);
            var KTModalCheck = function () {
                var t, e, n, a, o, i;
                return {
                    init: function () {
                        (i = document.querySelector("#kt_modal_repair")) && (o = new bootstrap.Modal(i),
                            a = document.querySelector("#kt_modal_repair_form"),
                            t = document.getElementById("kt_modal_repair_submit"),
                            e = document.getElementById("kt_modal_repair_cancel"),
                            n = FormValidation.formValidation(a, {
                                fields: {
                                    tgl_persetujuan: {
                                        validators: {
                                            notEmpty: {
                                                message: "Approval Date is Required"
                                            }
                                        }
                                    },
                                    no_wo: {
                                        validators: {
                                            notEmpty: {
                                                message: "Work Order is Required"
                                            }
                                        }
                                    },
                                    id_dealer: {
                                        validators: {
                                            notEmpty: {
                                                message: "Dealer is Required"
                                            }
                                        }
                                    },
                                    tgl_perbaikan: {
                                        validators: {
                                            notEmpty: {
                                                message: "Repair at is Required"
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
                                            text: "Approval is submitted.",
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
                                        text: "Your Approval Hasn't been Canceled!.",
                                        icon: "error",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
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
                KTModalCheck.init()
            }));
        } else {
            // text.style.display = "none";
            text.innerText = "Rejected";
            reparation.setAttribute('hidden', true);
            component.setAttribute('hidden', true);
            status.setAttribute('value', 't');
        }
    }

    var KTModalUncheck = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_repair")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_repair_form"),
                    t = document.getElementById("kt_modal_repair_submit"),
                    e = document.getElementById("kt_modal_repair_cancel"),
                    n = FormValidation.formValidation(a, {
                        fields: {
                            tgl_persetujuan: {
                                validators: {
                                    notEmpty: {
                                        message: "Approval Date is Required"
                                    }
                                }
                            },
                            no_wo: {
                                validators: {
                                    notEmpty: {
                                        message: "Work Order is Required"
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
                                    text: "Approval is submitted.",
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
                                text: "Your Approval Hasn't been Canceled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
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
        KTModalUncheck.init()
    }));
</script>
@endpush
