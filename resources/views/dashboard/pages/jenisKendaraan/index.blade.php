@extends('layouts.backend.main')

@section('title','Master | Jenis Kendaraan')
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
                        <span class="card-label fw-bolder fs-3 mb-1">Data Jenis Kendaraan</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{$jenisKendaraan->count()}}
                            Jenis Kendaraan</span>
                    </h3>
                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover"
                        title="" data-bs-original-title="Click to add a user">
                        <a href="#" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_new_target">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                            <span class="svg-icon svg-icon-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                        transform="rotate(-90 11.364 20.364)" fill="black"></rect>
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black"></rect>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->Tambah Jenis Kendaraan
                        </a>
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <!--begin::Table container-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table id="kt_datatable_example_5"
                            class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowrap">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="fw-bolder text-muted">
                                    {{-- <th class="w-25px">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                data-kt-check="true" data-kt-check-target=".widget-9-check">
                                        </div>
                                    </th> --}}
                                    <th class="min-w-10px">No</th>
                                    <th class="min-w-140px">Jenis Kendaraan</th>
                                    <th class="min-w-120px">Status</th>
                                    <th class="min-w-100px text-end">Aksi</th>
                                </tr>
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody>
                                @foreach ($jenisKendaraan as $index => $jKendaraan)
                                <tr>
                                    {{-- <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input widget-9-check" type="checkbox" value="1">
                                        </div>
                                    </td> --}}
                                    <td>
                                        {{-- {{ $index+ $jenisKendaraan->firstItem() }} --}}
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="#"
                                            class="text-dark fw-bolder text-hover-primary d-block fs-6">{{$jKendaraan->nama_jenis}}</a>
                                    </td>
                                    <td class="text-start">
                                        @if ($jKendaraan->status == 'y')
                                        <span class="badge badge-light-primary">Aktif</span>
                                        @else
                                        <span class="badge badge-light-danger">Non Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end flex-shrink-0">
                                            <a href="{{ route('dashboard.kendaraan.jenis.edit', $jKendaraan->id_jenis_kendaraan)}}"
                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3"
                                                            d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                                            fill="black"></path>
                                                        <path
                                                            d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                                            fill="black"></path>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>

                            </tfoot>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                        <!--begin::Block-->
                        {{-- <div class="py-0">
                            <div class="rounded border p-0">
                                @if ($jenisKendaraan->lastPage() > 1)
                                <ul class="pagination pagination-outline">
                                    @if ($jenisKendaraan->currentPage() != $jenisKendaraan->onFirstPage())
                                    <li class="page-item previous m-1">
                                        <a href="{{ $jenisKendaraan->previousPageUrl() }}" class="page-link">
                                            <i class="previous"></i>
                                        </a>
                                    </li>
                                    @endif
                                    @for ($i = 1; $i <= $jenisKendaraan->lastPage(); $i++)
                                        <li
                                            class="page-item {{ $i == $jenisKendaraan->currentPage() ? 'active' : '' }} m-1">
                                            <a href="{{ $jenisKendaraan->url($i) }}"
                                                class="page-link {{ $i == $jenisKendaraan->currentPage() ? 'current' : '' }}">{{$i}}</a>
                                        </li>
                                        @endfor
                                        @if ($jenisKendaraan->currentPage() != $jenisKendaraan->lastPage())
                                        <li class="page-item next m-1">
                                            <a href="{{ $jenisKendaraan->nextPageUrl()  }}" class="page-link">
                                                <i class="next"></i>
                                            </a>
                                        </li>
                                        @endif
                                </ul>
                                @endif
                            </div>
                        </div> --}}
                        <!--end::Block-->
                    </div>
                    <!--end::Table container-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
        <!--end::Container-->
    </div>

    <!--begin::Modal - New Target-->
    <div class="modal fade" id="kt_modal_new_target" tabindex="-1" aria-hidden="true">
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
                    <form id="kt_modal_new_target_form" class="form"
                        action="{{route('dashboard.kendaraan.jenis.store')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Input Jenis Kendaraan</h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="text-muted fw-bold fs-5">Jika memerlukan info lebih lanjut, silahkan klik
                                <a href="#" class="fw-bolder link-primary">Manual Book</a>.
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Nama Jenis Kendaraan</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Sesuaikan dengan data dinas perhubungan"></i>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Target Title"
                                name="nama_jenis" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            {{-- <div class="col-md-6 fv-row"> --}}
                                <label class="required fs-6 fw-bold mb-2">Status (Aktif/Non Aktif)</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Pilih Status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option value="y">Aktif</option>
                                    <option value="t">Non Aktif</option>
                                </select>
                                {{--
                            </div> --}}
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_target_cancel"
                                class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
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
    <!--end::Modal - New Target-->
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
<script src="{{url('assets/backend/assets/js/custom/modals/new-target.js')}}"></script>
{{-- <script src="{{ url('assets/backend/assets/js/custom/documentation/general/datatables/advanced.js') }}"></script>
--}}
<!--end::Page Custom Javascript-->
<script text="text/javascipt">

    $(document).ready(function () {
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
    });
</script>
@endpush
