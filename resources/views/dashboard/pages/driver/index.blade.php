@extends('layouts.backend.main')

@section('title','Master | Driver')
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
                        <span class="card-label fw-bolder fs-3 mb-1">Data Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Lebih dari 2 Driver</span>
                    </h3>
                    <div class="card-toolbar btn-toolbar">
                        <div class="btn-group me-2" role="group">
                            <a href="{{ route('dashboard.driver.create') }}"
                                class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-trigger="hover" title=""
                                data-bs-original-title="Tekan untuk menambah driver">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                            transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Tambah Driver
                            </a>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="{{ route('dashboard.driver.password.all.reset') }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-trigger="hover" title=""
                                data-bs-original-title="Tekan untuk mereset semua username dan password driver"
                                class="btn btn-sm btn-light btn-active-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <i class="bi bi-bootstrap-reboot"></i>
                                </span>
                                <!--end::Svg Icon-->Reset
                            </a>
                        </div>
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
                            <h5 class="mb-1">Pesan</h5>
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
                    <table id="kt_datatable_example_5"
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                <th>No</th>
                                <th>No Badge</th>
                                <th>Driver</th>
                                <th>Departemen</th>
                                <th>Alamat</th>
                                <th>No. Tlpn</th>
                                <th>Usia</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($driver as $dr)
                            <tr class="odd">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$dr->no_badge}}</td>
                                <td>
                                    <!--begin:: Avatar -->
                                    <div class="symbol symbol-circle symbol-50px overflow-hidden">
                                        <div class="symbol-label">
                                            <img @if ($dr->foto_driver != null)
                                            src="{{url('/assets/img_driver/'.$dr->foto_driver)}}"
                                            @else
                                            src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                            @endif
                                            class="w-100" />
                                        </div>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::User details-->
                                    <div class="d-flex flex-column">
                                        {{$dr->nama_driver}}
                                    </div>
                                    <!--begin::User details-->
                                </td>
                                <td>
                                    @if ($dr->id_departemen == null)
                                    ---
                                    @endif
                                    {{$dr->nama_departemen}}
                                </td>
                                <td>{{$dr->alamat}}</td>
                                <td>{{$dr->no_tlp}}</td>
                                <td>{{$dr->umur}}</td>
                                <td>
                                    @if ($dr->status == 'y')
                                    <span class="badge badge-light-primary">Aktif</span>
                                    @else
                                    <span class="badge badge-light-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center flex-shrink-0">
                                        <a href="{{route('dashboard.driver.edit', $dr->id_driver)}}"
                                            class=" btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-pencil-square fs-6"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <a href="{{ route('dashboard.driver.password.reset.satu', $dr->id_driver)}}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                                            title=""
                                            data-bs-original-title="Tekan untuk mereset username dan password driver"
                                            class=" btn btn-icon btn-bg-warning btn-active-color-primary btn-sm me-1">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <i class="bi bi-bootstrap-reboot"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
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
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/js/custom/documentation/documentation.js') }}"></script>
<script src="{{ url('assets/backend/assets/js/custom/documentation/search.js') }}"></script>
{{-- <script src="{{ url('assets/backend/assets/js/custom/documentation/general/datatables/advanced.js') }}"></script>
--}}
<!--end::Page Custom Javascript-->
<script text="text/javascipt">
    $("#kt_datatable_example_5").DataTable({
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
