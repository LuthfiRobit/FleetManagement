@extends('layouts.backend.main')

@section('title','Status Penugasan Driver | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">STATUS PENUGASAN DRIVER</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ada
                            {{$assignment->where('status_penugasan','p')->count()}}
                            Driver Sedang Dalam Perjalanan</span>
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
                    <table id="kt_datatable_do"
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th>No.</th>
                                <th>No. DO</th>
                                <th>Driver</th>
                                <th>Pemesan</th>
                                <th>Kendaraan</th>
                                <th>Tanggal | Jam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignment as $as)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>DO_{{$as->no_so}}</td>
                                <td>{{$as->nama_driver}}</td>
                                <td>{{$as->nama_petugas}}</td>
                                <td>{{$as->nama_kendaraan}}
                                    <br>
                                    <span class="badge badge-light-primary">{{$as->no_polisi}}</span>
                                </td>
                                <td>
                                    {{Carbon\Carbon::parse($as->tgl_penugasan)->format('d F Y') }} |
                                    {{Carbon\Carbon::parse($as->jam_berangkat)->format('H:i') }}
                                </td>
                                <td>
                                    @if ($as->status_do == 't')
                                    <span class="badge badge-light-primary">Diterima</span>
                                    @elseif($as->status_do == 'p')
                                    <span class="badge badge-light-danger">Process</span>
                                    @elseif($as->status_do == 's')
                                    <span class="badge badge-light-success">Selesai</span>
                                    @elseif($as->status_do == 'c')
                                    <span class="badge badge-light-success">Batal</span>
                                    @else
                                    <span class="badge badge-light-warning">Baru</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('assign.detail', $as->id_do)}}"
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
    $("#kt_datatable_do").DataTable({
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
</script>
@endpush
