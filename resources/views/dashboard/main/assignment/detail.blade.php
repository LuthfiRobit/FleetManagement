@extends('layouts.backend.main')

@section('title','Driver Assginment | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">Detail Penugasan Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Driver : {{$detail->nama_driver}}</span>
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
                                    class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$detail->nama_driver}}</a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="mb-9">
                                    <!--begin::Badge-->
                                    @if ($detail->status_do == 't')
                                    <div class="badge badge-lg badge-light-primary d-inline">
                                        Diterima
                                    </div>
                                    @elseif($detail->status_do == 'p')
                                    <div class="badge badge-lg badge-light-danger d-inline">
                                        Process
                                    </div>
                                    @elseif($detail->status_do)
                                    <div class="badge badge-lg badge-light-success d-inline">
                                        Selesai
                                    </div>
                                    @else
                                    <div class="badge badge-lg badge-light-warning d-inline">
                                        Baru
                                    </div>
                                    @endif
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
                                <span data-bs-toggle="tooltip" title="" data-bs-original-title="Pessengers Amount">
                                    <a class="btn btn-sm btn-light-primary active">{{$penumpang->count()}}</a>
                                </span>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details">
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed gy-5">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Nama</th>
                                                <th>No. Telepon</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach ($penumpang as $ps)
                                            <tr>
                                                <td>{{$ps->nama_penumpang}}</td>
                                                <td>{{$ps->no_tlp}}</td>
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
                                <h2 class="mb-1">ID Dispath Order</h2>
                                <div class="fs-6 fw-bold text-muted">DO_{{$detail->id_do}}</div>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <div class="fw-bold ms-5">
                                    <a
                                        class="fs-5 fw-bolder text-dark text-hover-primary">{{$detail->nama_kendaraan}}</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{$detail->no_polisi}}
                                    </div>
                                    <!--end::Info-->
                                </div>
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
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Tanggal dan Jam
                                        Penjemputan</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{Carbon\Carbon::parse($detail->tgl_penugasan)->format('d F Y')}} |
                                        {{Carbon\Carbon::parse($detail->jam_berangkat)->format('H:i')}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Tempat Penjemputan</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{$detail->tempat_penjemputan}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Tempat Tujuan</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{$detail->tujuan}}
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <div class="d-flex align-items-center position-relative mb-7">
                                <!--begin::Label-->
                                <div class="position-absolute top-0 start-0 rounded h-100 bg-secondary w-4px"></div>
                                <!--end::Label-->
                                <!--begin::Details-->
                                <div class="fw-bold ms-5">
                                    <a class="fs-5 fw-bolder text-dark text-hover-primary">Tempat Kembali</a>
                                    <!--begin::Info-->
                                    <div class="fs-7 text-muted">
                                        {{$detail->kembali}}
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
</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";
</script>
@endpush
