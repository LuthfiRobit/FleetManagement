{{-- <div>
    @foreach ($biaya_penugasan as $item)

    @if ($item['acc_oleh']== null)
    ok
    @else
    {{$item['acc_oleh']}}
    @endif
    @endforeach
</div> --}}
@extends('layouts.backend.main')

@section('title','Biaya Penugasan | Utama')
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
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Tagihan Biaya Penugasan</span>
                        <span class="text-muted mt-1 fw-bold fs-7"></span>
                    </h3>
                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
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
                    <!--begin::Table container-->
                    <table id="kt_datatable_so"
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th>No</th>
                                <th>No. SO</th>
                                <th>Driver</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($biaya_penugasan as $bp)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>SO_{{$bp['no_so']}}</td>
                                <td>{{$bp['nama_driver']}}</td>
                                <td>{{Carbon\Carbon::parse($bp['tgl_pengajuan'])->format('d F Y') }}</td>
                                <td>{{$bp['total']}}</td>
                                <td>
                                    @if ($bp['acc_oleh'] != null)
                                    @php
                                    $tags = explode(',' , $bp['acc_oleh']);
                                    $num_tags = count($tags);
                                    @endphp
                                    @if ($num_tags == 1)
                                    <span class="badge badge-light-danger">BUTUH APPROVAL SF SPV</span>
                                    @endif
                                    @if($num_tags == 2)
                                    <span class="badge badge-light-success">APPROVED SC & SF SPV</span>
                                    @endif
                                    @else
                                    <span class="badge badge-light-warning">BUTUH APPROVAL SC</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="{{route('biaya.detail', $bp['id_biaya'])}}"
                                        class="btn btn-light bnt-active-light-primary btn-sm">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!--end::Table container-->
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
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors Javascript-->
<script text="text/javascipt">
    $("#kt_datatable_so").DataTable({
        "language": {
            "lengthMenu": "Show _MENU_",
        },
        "dom":
            "<'row'" +
            "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
            "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
            ">" +

            "<'table-responsive'tr>" +

            "<'row'" +
            "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
            "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
            ">"
    });
    function logout(id) {
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
    $(function () {
        $('.btn-cancel').each(function () {
            var id = $(this).data('id');
            var so = $(this).data('so');
            var oleh = $(this).data('petugas');
            var url = '{{route("checking.serviceorder.cancel",":id")}}';
            url = url.replace(':id', id);
            $(this).on("click", (t => {
            t.preventDefault(), Swal.fire({
                html:
                    'Apakah anda yakin membatalkan penugasan dengan <b>SO_'+so+'</b>, ' +
                    'oleh <b>'+oleh+'</b>?',
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Ya, batalkan",
                cancelButtonText: "Tidak, kembali",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then((function (t) {
                t.value ? Swal.fire({
                    text: "Anda telah membatalkan penugasan, penugasan tidak bisa diproses kembali!.",
                    icon: "success",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then((function (t) {
                        window.location.href = url
                    }))
                    : "cancel" === t.dismiss && Swal.fire({
                    text: "Penugasan masih aktif!.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }))
            }));
        });
    });
</script>
@endpush
