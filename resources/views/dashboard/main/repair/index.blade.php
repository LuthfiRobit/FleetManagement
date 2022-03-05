@extends('layouts.backend.main')

@section('title','Laporan Perbaikan | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">LAPORAN PERBAIKAN KENDARAAN</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ada
                            {{$perbaikan->where('status_perbaikan','p')->count()}} Dalam Proses</span>
                    </h3>

                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_proses">PROSES</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                href="#tab_done">SELESAI</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
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

                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="tab_proses" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_proses"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. WO</th>
                                        <th>Dealer</th>
                                        <th>Kendaraan</th>
                                        <th>Tgl. Mulai</th>
                                        <th>Tgl. Penyelesaian</th>
                                        <th>Status Perbaikan</th>
                                        <th>Status Penyelesaian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perbaikan->where('status_perbaikan','p') as $pr)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>WO_{{$pr->no_wo}}</td>
                                        <td>{{$pr->nama_dealer}}</td>
                                        <td>
                                            {{$pr->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-primary">{{$pr->no_polisi}}</span>
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_perbaikan)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_selesai)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            @if($pr->status_perbaikan == 's')
                                            <span class="badge badge-light-primary">SELESAI</span>
                                            @else
                                            <span class="badge badge-light-warning">PROSES</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pr->status_penyelesaian == 'o')
                                            <span class="badge badge-light-primary">ON TIME</span>
                                            @elseif($pr->status_penyelesaian == 'p')
                                            <span class="badge badge-light-danger">PENALTI</span>
                                            @else
                                            <span class="badge badge-light-warning">BELUM</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('repair.invoice', $pr->id_perbaikan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Selesaikan</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show " id="tab_done" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_done"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. WO</th>
                                        <th>Dealer</th>
                                        <th>Kendaraan</th>
                                        <th>Tgl. Mulai</th>
                                        <th>Tgl. Penyelesaian</th>
                                        <th>Status Perbaikan</th>
                                        <th>Status Penyelesaian</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($perbaikan->where('status_perbaikan','s') as $pr)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>WO_{{$pr->no_wo}}</td>
                                        <td>{{$pr->nama_dealer}}</td>
                                        <td>
                                            {{$pr->nama_kendaraan}}
                                            <br>
                                            <span class="badge badge-light-primary">{{$pr->no_polisi}}</span>
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_perbaikan)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($pr->tgl_selesai)->format('d, M Y')}}
                                        </td>
                                        <td>
                                            @if($pr->status_perbaikan == 's')
                                            <span class="badge badge-light-primary">SELESAI</span>
                                            @else
                                            <span class="badge badge-light-warning">PROSES</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pr->status_penyelesaian == 'o')
                                            <span class="badge badge-light-primary">ON TIME</span>
                                            @elseif($pr->status_penyelesaian == 'p')
                                            <span class="badge badge-light-danger">PENALTI</span>
                                            @else
                                            <span class="badge badge-light-warning">BELUM</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('repair.detail', $pr->id_perbaikan)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                    </div>
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
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}">
</script>
<!--end::Page Vendors Javascript-->
<script text="text/javascipt">
    $("#kt_datatable_done").DataTable({
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

    $("#kt_datatable_proses").DataTable({
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
