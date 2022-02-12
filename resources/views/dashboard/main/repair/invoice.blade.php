@extends('layouts.backend.main')

@section('title','Laporan Perbaikan | Penyelesaian')
@section('style-on-this-page-only')
<link href="{{url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
    type="text/css" />
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                    <!--begin::Card-->
                    <div class="card">
                        <!--begin::Card body-->
                        <div class="card-body p-12">
                            <!--begin::Form-->
                            <form action="" id="kt_invoice_form">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column align-items-start flex-xxl-row">
                                    <!--begin::Input group-->
                                    <div class="d-flex align-items-center flex-equal fw-row me-4 order-2"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" title="Tgl. Batas">
                                        <!--begin::Date-->
                                        <div class="fs-6 fw-bolder text-gray-700 text-nowrap">Batas:</div>
                                        <!--end::Date-->
                                        <!--begin::Input-->
                                        <div class="position-relative d-flex align-items-center w-150px">
                                            <!--begin::Datepicker-->
                                            <input class="form-control form-control-white fw-bolder pe-5"
                                                placeholder="Select date" name="invoice_date"
                                                value="{{\Carbon\Carbon::parse($perbaikan->tgl_selesai)->format('d, M Y')}}"
                                                disabled />
                                            <!--end::Datepicker-->
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex flex-center flex-equal fw-row text-nowrap order-1 order-xxl-2 me-4"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" title="No. WO">
                                        <span class="fs-1x fw-bolder text-gray-800">Invoice Wo.</span>
                                        <input type="text"
                                            class="form-control form-control-flush fw-bolder text-muted fs-3 w-125px"
                                            value="{{$perbaikan->no_wo}}" disabled />
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="d-flex align-items-center justify-content-end flex-equal order-3 fw-row"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" title="Tgl. Selesai">
                                        <!--begin::Date-->
                                        <div class="fs-6 fw-bolder text-gray-700 text-nowrap">Selesai:</div>
                                        <!--end::Date-->
                                        <!--begin::Input-->
                                        <div class="position-relative d-flex align-items-center w-150px">
                                            <!--begin::Datepicker-->
                                            <input class="form-control form-control-white fw-bolder pe-1" type="date"
                                                placeholder="pilih" name="invoice_due_date" id='tgl_penyelesaian'
                                                value="{{date('Y-m-d')}}" />
                                            <!--end::Datepicker-->
                                            {{-- <span class="svg-icon svg-icon-2 position-absolute end-0 ms-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                        fill="black" />
                                                </svg>
                                            </span> --}}
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-5"></div>
                                <!--end::Separator-->
                                <!--begin::Wrapper-->
                                <div class="mb-0">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive mb-10">
                                        <!--begin::Table-->
                                        <table class="table g-5 gs-0 mb-0 fw-bolder text-gray-700"
                                            data-kt-element="items" id="table_komponen">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="border-bottom fs-7 fw-bolder text-gray-700 text-uppercase">
                                                    <th class="min-w-150px w-150px">Komponen</th>
                                                    <th class="min-w-75px w-75px">Jumlah</th>
                                                    <th class="min-w-150px w-150px">Harga</th>
                                                    <th class="min-w-100px w-150px text-end">Total</th>
                                                    {{-- <th class="min-w-75px w-75px text-end">Action</th> --}}
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>
                                                @foreach ($detail_perbaikan as $dp)
                                                <tr class="border-bottom border-bottom-dashed" data-kt-element="item">
                                                    <td class="pe-7">
                                                        {{-- <input type="text"
                                                            class="form-control form-control-solid mb-2" name="name[]"
                                                            placeholder="Item name" value="{{$dp->nama_komponen}}"
                                                            disabled /> --}}
                                                        <span>{{$dp->nama_komponen}}</span>
                                                    </td>
                                                    <td class="ps-0">
                                                        <input class="form-control form-control-solid" type="number"
                                                            min="1" name="quantity[]" placeholder="1"
                                                            value="{{$dp->jml_komponen}}" data-kt-element="quantity"
                                                            data-id="{{$dp->id_ganti}}" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-solid text-end"
                                                            name="price[]" placeholder="0" data-kt-element="price"
                                                            data-id="{{$dp->id_ganti}}" />
                                                    </td>
                                                    <td class="pt-8 text-end text-nowrap">Rp.
                                                        <span data-kt-element="total">0</span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                            <!--begin::Table foot-->
                                            <tfoot>
                                                <tr
                                                    class="border-top border-top-dashed align-top fs-6 fw-bolder text-gray-700">
                                                    <th class="text-primary">
                                                    </th>
                                                    <th colspan="2" class="border-bottom border-bottom-dashed ps-0">
                                                        <div class="d-flex flex-column align-items-start">
                                                            <div class="fs-5">Subtotal</div>
                                                        </div>
                                                    </th>
                                                    <th colspan="2" class="border-bottom border-bottom-dashed text-end">
                                                        Rp.
                                                        <span data-kt-element="sub-total">0</span>
                                                    </th>
                                                </tr>
                                                <tr class="align-top fw-bolder text-gray-700">
                                                    <th></th>
                                                    <th colspan="2" class="fs-4 ps-0">Total</th>
                                                    <th colspan="2" class="text-end fs-4 text-nowrap">Rp.
                                                        <dd data-kt-element="grand-total" id="total_biaya">0</dd>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                            <!--end::Table foot-->
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Wrapper-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-lg-auto min-w-lg-300px">
                    <!--begin::Card-->
                    <div class="card" data-kt-sticky="true" data-kt-sticky-name="invoice"
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', lg: '300px'}" data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card body-->
                        <div class="card-body p-10">
                            <!--begin::Input group-->
                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-bolder fs-5 text-gray-700 mb-5">DETAIL KENDARAAN</label>
                                <!--end::Label-->
                                <div class="min-w-125px pe-1 mb-5">
                                    <div class="fw-bold text-gray-600 fs-7">Kendaraan:</div>
                                    <div class="fw-bolder fs-6 text-gray-800">{{$perbaikan->nama_kendaraan}} |
                                        <a href="#" class="link-primary ps-1">{{$perbaikan->no_polisi}}</a>
                                    </div>
                                </div>
                                <div class="min-w-125px pe-1">
                                    <div class="fw-bold text-gray-600 fs-7">Kilometer/pengecekan:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->km_kendaraan}} Km.</div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-5"></div>
                            <!--end::Separator-->
                            <!--begin::Input group-->
                            <div class="mb-5">
                                <label class="form-label fw-bolder fs-5 text-gray-700 mb-5">DETAIL DEALER</label>
                                <div class="min-w-125px pe-1 mb-5">
                                    <div class="fw-bold text-gray-600 fs-7">Dealer:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->nama_dealer}} |
                                        @if ($perbaikan->status_dealer == 'p')
                                        <span class="badge badge-light-primary">Perusahaan</span>
                                        @else
                                        <span class="badge badge-light-warning">Partner</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="min-w-125px pe-1">
                                    <div class="fw-bold text-gray-600 fs-7">Alamat:</div>
                                    <div class="fw-bolder text-gray-800 fs-6">{{$perbaikan->alamat}}
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed mb-8"></div>
                            <!--end::Separator-->
                            <!--begin::Actions-->
                            <div class="mb-0">
                                <button type="submit" href="#" class="btn btn-primary w-100" disabled
                                    id="kt_invoice_submit_button">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen016.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z"
                                                fill="black" />
                                            <path opacity="0.3"
                                                d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z"
                                                fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->Tuntaskan
                                </button>
                            </div>
                            <!--end::Actions-->
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
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}">
</script>
<!--end::Page Vendors Javascript-->
<script text="text/javascipt">
    "use strict";
    var KTAppInvoicesCreate = function () {
        var e, t = function () {
                var t = [].slice.call(e.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]')),
                    a = 0,
                    n = wNumb({
                        decimals: 0,
                        // thousand: ","
                    });
                t.map((function (e) {
                    var t = e.querySelector('[data-kt-element="quantity"]'),
                        l = e.querySelector('[data-kt-element="price"]'),
                        r = n.from(l.value);
                    r = !r || r < 0 ? 0 : r;
                    var i = parseInt(t.value);
                    i = !i || i < 0 ? 1 : i, l.value = n.to(r), t.value = i, e.querySelector('[data-kt-element="total"]').innerText = n.to(r * i), a += r * i
                })), e.querySelector('[data-kt-element="sub-total"]').innerText = n.to(a), e.querySelector('[data-kt-element="grand-total"]').innerText = n.to(a)
            }
        ;
        return {
            init: function (n) {
                (e = document.querySelector("#kt_invoice_form")).querySelector('[data-kt-element="items"]').addEventListener("click", (function (n) {
                    // n.preventDefault();
                    // var l = e.querySelector('[data-kt-element="item-template"] tr').cloneNode(!0);
                    // e.querySelector('[data-kt-element="items"] tbody').appendChild(l), a(), t()
                }))
                // ,
                //  KTUtil.on(e, '[data-kt-element="items"] [data-kt-element="remove-item"]', "click", (function (e) {
                //     e.preventDefault(), KTUtil.remove(this.closest('[data-kt-element="item"]')), a(), t()
                // }))
                ,
                KTUtil.on(e, '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="price"]', "change", (function (e) {
                    e.preventDefault(), t(),
                    document.querySelector("#kt_invoice_submit_button").removeAttribute("disabled")
                }))
                ,
                // $(e.querySelector('[name="invoice_date"]')).flatpickr({
                //     enableTime: !3,
                //     dateFormat: "d, M Y"
                // }),
                // $(e.querySelector('[name="invoice_due_date"]')).flatpickr({
                //     enableTime: !1,
                //     dateFormat: "d-m-Y"
                // }),
                t()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function () {
        KTAppInvoicesCreate.init()
    }));

    $(function () {

        $('[data-kt-element="quantity"]').on('change', function () {
            console.log($(this).data('id'));
            console.log($(this).val());
            $.ajax({
                type: 'POST',
                url: '{{route("repair.invoice.jml")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id_detail': $(this).data('id'),
                    'jml':$(this).val()
                },
                datatype: 'JSON',
                success: function (response) {
                    console.log(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('[data-kt-element="price"]').on('change', function () {
            console.log($(this).data('id'));
            console.log($(this).val());
            $.ajax({
                type: 'POST',
                url: '{{route("repair.invoice.harga")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id_detail': $(this).data('id'),
                    'harga':$(this).val()
                },
                datatype: 'JSON',
                success: function (response) {
                    console.log(response);
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $('#kt_invoice_submit_button').on('click', function () {
            // var span_Text = document.getElementById("total_biaya").innerText;
            // var tgl = document.getElementById("tgl_penyelesaian").value;
            // console.log(tgl);
            // event.preventDefault();
            // console.table($('#table_komponen').serializeArray());
            // console.log($('#table_komponen').serializeArray());
            var valid = true;
            $('[data-kt-element="price"]').each(function () {
                var el = $(this);
                if(el.val() == 0 ) {
                    // el.parent().find('.verdiv').addClass('error');
                    // el.parent().effect("shake", { times:3 }, 50);
                    valid = false;
                    console.log(valid);
                    Swal.fire({
                        text: "Salah satu harga belum diisi.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, saya mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{route("repair.update",$perbaikan->id_perbaikan)}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'total_biaya': document.getElementById("total_biaya").innerText,
                    'tgl_penyelesaian': document.getElementById("tgl_penyelesaian").value,
                },
                datatype: 'JSON',
                success: function (response) {
                    Swal.fire({
                        text: "Anda telah melakukan penyelesaian perbaikan!.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, saya mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        },
                    }).then((function (t) {
                        window.location.href = "{{route('repair.main')}}"
                        }))
                    console.log(response)
                },
                error: function (response) {
                    console.log(response)
                    Swal.fire({
                        text: "Gagal selesaikan perbaikan!.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, saya mengerti!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    })
                }
            });
            //tempat ajax
            return valid
        });
    });
</script>
@endpush
