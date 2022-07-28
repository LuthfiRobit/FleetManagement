@extends('layouts.backend.main')

@section('title','Status Driver Cuti | Utama')
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
                        <span class="card-label fw-bolder fs-3 mb-1">STATUS DRIVER CUTI</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Ada
                            {{$status->where('status','n')->count()}} sedang cuti</span>
                    </h3>
                    <ul
                        class="align-items-end  nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#tab_avaliable">CUTI</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#tab_unavaliable">AKTIF</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
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

                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="tab_avaliable" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_nonaktif"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. Status</th>
                                        <th>Driver</th>
                                        <th>Tgl. Cuti</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status->where('status','n') as $sd)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>SD_{{$sd->id_status}}</td>
                                        <td>{{$sd->nama_driver}}</td>
                                        <td>{{$sd->tgl_nonaktif}}</td>
                                        <td>
                                            @if ($sd->status == 'n')
                                            <span class="badge badge-light-danger">Cuti</span>
                                            @else
                                            <span class="badge badge-light-primary">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('status.detail', $sd->id_status)}}"
                                                class="btn btn-light bnt-active-light-primary btn-sm">Detail</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end::Table container-->
                        </div>
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show " id="tab_unavaliable" role="tabpanel">
                            <!--begin::Table container-->
                            <table id="kt_datatable_aktif"
                                class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                <thead>
                                    <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                        <th>No.</th>
                                        <th>No. Status</th>
                                        <th>Driver</th>
                                        <th>Tgl. Cuti</th>
                                        <th>Tgl. Aktif</th>
                                        <th>Jml. Hari</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($status->where('status','r') as $sd)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>SD_{{$sd->id_status}}</td>
                                        <td>{{$sd->nama_driver}}</td>
                                        <td>{{$sd->tgl_nonaktif}}</td>
                                        <td>{{$sd->tgl_aktif}}</td>
                                        <td>{{$sd->jml_nonaktif}}</td>
                                        <td>
                                            @if ($sd->status == 'n')
                                            <span class="badge badge-light-danger">Cuti</span>
                                            @else
                                            <span class="badge badge-light-primary">Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{route('status.detail', $sd->id_status)}}"
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

    $(document).ready(function () {
        $("#kt_datatable_nonaktif").DataTable({
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
        $("#kt_datatable_aktif").DataTable({
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
    });
</script>
@endpush
