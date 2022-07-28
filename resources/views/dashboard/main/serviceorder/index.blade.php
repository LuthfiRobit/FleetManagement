@extends('layouts.backend.main')

@section('title','Penugasan Driver | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">Penugasan Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7"></span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        title="" data-bs-original-title="Tekan untuk membuat penugasan">
                        <a href="{{ route('checking.serviceorder.form') }}"
                            class="btn btn-sm btn-light btn-active-primary">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Buat Penugasan
                        </a>
                    </div>
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
                                <th>Petugas</th>
                                <th>Pemesan</th>
                                <th>Tanggal | Jam</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($serviceOrder as $so)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>SO_{{$so->no_so}}</td>
                                <td class="text-center">{{$so->nama_lengkap}}</td>
                                <td class="text-center">{{$so->nama_pemesan}}
                                    <br>
                                    <span class="badge badge-light-primary">{{$so->departemen_pemesan}}</span>
                                </td>
                                <td>{{Carbon\Carbon::parse($so->tgl_penjemputan)->format('d F Y') }} |
                                    {{Carbon\Carbon::parse($so->jam_penjemputan)->format('H:i') }}</td>
                                <td>
                                    {{\Illuminate\Support\Str::words($so->tujuan,5, '...')}}
                                    <br>
                                    @if ($so->status_tujuan == 'l')
                                    <span class="badge badge-light-primary">Lokal</span>
                                    @elseif($so->status_tujuan == 'o')
                                    <span class="badge badge-light-danger">Out Of Town</span>
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td>
                                    @if ($so->status_so == 't')
                                    <span class="badge badge-light-primary">Penugasan</span>
                                    @elseif($so->status_so == 'tl')
                                    <span class="badge badge-light-danger">Ditolak</span>
                                    @elseif($so->status_so == 'c')
                                    <span class="badge badge-light-success">Dibatalkan</span>
                                    @else
                                    <span class="badge badge-light-warning">Butuh Respon</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($so->status_penugasan == null || $so->status_penugasan == 't')
                                    <button type="button" class="btn btn-light btn-light-danger btn-sm btn-cancel mb-1"
                                        data-id="{{$so->id_service_order}}" data-so="{{$so->no_so}}"
                                        data-petugas="{{$so->nama_lengkap}}">Batalkan</button>
                                    <a href="{{route('checking.serviceorder.edit',$so->id_service_order)}}"
                                    class="btn btn-light bnt-active-light-primary btn-sm mb-1">Edit</a>
                                    @endif
                                    <a href="{{route('checking.serviceorder.detail',$so->id_service_order)}}"
                                        class="btn btn-light bnt-active-light-primary btn-sm">Lihat</a>
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
    $(document).ready( function () {
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
    } );
    const allButtons = document.querySelectorAll(".btn-cancel");

    allButtons.forEach(function (button) {
        button.addEventListener("click", (e) => {
            var id = button.getAttribute('data-id');
            var so = button.getAttribute('data-so');
            var oleh = button.getAttribute('data-petugas');
            // alert(id);
            var url = '{{route("checking.serviceorder.cancel",":id")}}';
            url = url.replace(':id', id);
            Swal.fire({
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
        });
    });
</script>
@endpush
