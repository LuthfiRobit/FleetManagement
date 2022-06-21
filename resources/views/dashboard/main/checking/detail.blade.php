@extends('layouts.backend.main')

@section('title','Laporan Pengecekan | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL LAPORAN PENGECEKAN</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Oleh : {{$pengecekan->nama_driver}}</span>
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
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">PENGECEKAN</h2>
                            </div>
                            <!--begin::Card title-->

                            <div class="card-toolbar">
                                @if ($pengecekan->status_perbaikan == '')
                                <!--begin::Add-->
                                <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                    </span>Perbaikan
                                    <!--end::Svg Icon-->
                                </button>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_repair_accept">Terima Perbaikan</a>
                                        {{-- <a href="#" class="menu-link px-3" id="modal_accept"">Accept</a> --}}
                                 </div>
                                 <!--end::Menu item-->
                                 <!--begin::Menu item-->
                                 <div class=" menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_reject">Tolak Perbaikan</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::Add-->
                                @elseif($pengecekan->status_perbaikan == 'n')
                                <div
                                    class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-12 p-2">
                                    Dapat Beroprasi
                                </div>
                                @elseif($pengecekan->status_perbaikan == 't')
                                <div
                                    class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-12 p-2">
                                    Sedang Diperbaiki
                                </div>
                                @elseif($pengecekan->status_perbaikan == 'tl')
                                <div
                                    class="notice d-flex bg-light-danger rounded border-danger border border-dashed mb-12 p-2">
                                    Tidak Diperbaiki
                                </div>
                                @endif
                            </div>

                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">No. Pengecekan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a href="#"
                                                        class="text-gray-800 text-hover-primary">VC_{{$pengecekan->id_pengecekan}}</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Oleh:</td>
                                                <td class="text-gray-800">{{$pengecekan->nama_driver}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tanggal Pengecekan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($pengecekan->tgl_pengecekan)->format('d F
                                                    Y')}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Jam Pengecekan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($pengecekan->jam_pengecekan)->format('H:i')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Status Pengecekan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if($pengecekan->status_pengecekan == 'c')
                                                    <span class="badge badge-light-primary">Pengecekan Harian</span>
                                                    @else
                                                    <span class="badge badge-light-danger">Pengecekan Kecelakaan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Status Kendaraan:</td>
                                                <td class="text-gray-800">
                                                    @if($pengecekan->status_kendaraan == 'r')
                                                    <span class="badge badge-light-primary">Normal</span>
                                                    @else
                                                    <span class="badge badge-light-danger">Rusak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Waktu Pengecekan:</td>
                                                <td class="text-gray-800">
                                                    <span class="badge badge-light-primary">
                                                        @if ($detail->count() > 0)
                                                        @if ($detail[0]->waktu == 'm')
                                                        Pagi
                                                        @elseif ($detail[0]->waktu == 'a')
                                                        Siang
                                                        @else
                                                        Malam
                                                        @endif
                                                        @else
                                                        ---
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-gray-400">Keterangan Pengecekan:</td>
                                                <td class="text-gray-800">

                                                    @if ($pengecekan->keterangan_pengecekan != null)
                                                    {{$pengecekan->keterangan_pengecekan}}
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Komponen:</h5>
                                <!--end::Title-->
                                <!--begin::Product table-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    {{-- <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                        <!--begin::Table head-->
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                            <!--begin::Table row-->
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Kriteria</th>
                                                <th>Tipe</th>
                                                <th>Kondisi</th>
                                                <th class="min-w-125px">Keterangan</th>
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
                                                    <span class="badge badge-light-success">Baik/Normal</span>
                                                    @else
                                                    <span class="badge badge-light-danger">Rusak/Tidak Normal</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dp->keterangan != null)
                                                    {{$dp->keterangan}}
                                                    @else
                                                    ----
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table> --}}
                                    <!--end::Table-->

                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                        <!--begin::Table body-->
                                        <tbody class="fs-6 fw-bold text-gray-600">
                                            @foreach ($detail_check as $de)
                                            <tr>
                                                <td colspan="3" align="center"><strong>{{$de['nama_kriteria']}}</strong>
                                                </td>
                                                <td>
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th>Tipe</th>
                                                <th>Kondisi</th>
                                                <th class="min-w-125px">Keterangan</th>
                                            </tr>
                                            @forelse ($de['list_jenis'] as $dp)
                                            <tr>
                                                {{-- <td>{{$dp->kriteria}}</td> --}}
                                                <td>{{$dp['jenis']}}</td>
                                                <td>
                                                    @if($dp['kondisi'] == 'b')
                                                    <span class="badge badge-light-success">Baik/Normal</span>
                                                    @else
                                                    <span class="badge badge-light-danger">Rusak/Tidak Normal</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($dp['keterangan'] != null)
                                                    {{$dp['keterangan']}}
                                                    @else
                                                    ----
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="3" align="center">Belum ada pengecekan</td>
                                            </tr>
                                            @endforelse
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Product table-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <div class="mb-0">
                                <!--begin::Title-->
                                <h5 class="mb-4">Foto:</h5>
                                <!--end::Title-->
                                <!--begin::Card body-->
                                <div class="row g-10 row-cols-2 row-cols-lg-5">
                                    <!--begin::Col-->
                                    @foreach ($foto as $ft)
                                    <div class="col text-center">
                                        <!--begin::Overlay-->
                                        <a class="d-block overlay" data-fslightbox="lightbox-hot-sales"
                                            href="{{url('/assets/img_checking/'.$ft->foto_pengecekan)}}">
                                            <!--begin::Image-->
                                            <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                style="background-image:url('{{url('/assets/img_checking/'.$ft->foto_pengecekan)}}')">
                                            </div>
                                            <!--end::Image-->
                                            <!--begin::Action-->
                                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                <i class="bi bi-eye-fill fs-2x text-white"></i>
                                            </div>
                                            <!--end::Action-->
                                        </a>
                                        {{$ft->keterangan}}
                                    </div>
                                    @endforeach
                                    {{-- <div class="row text-center">
                                        @foreach ($foto as $ft)
                                        <div class="col-lg-3 col-md-2 mb-0 mb-lg-3">
                                            <div class="bg-image hover-overlay  bg-light-primary rounded border-primary border border-dashed"
                                                data-ripple-color="light">
                                                <img src="{{url('/assets/img_checking/'.$ft->foto_pengecekan)}}"
                                                    class="w-100" />
                                            </div>

                                        </div>
                                        @endforeach
                                    </div> --}}
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary"
                        data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{default: false}"
                        data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="true"
                        data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>KENDARAAN</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Nama Kendaraan:</td>
                                        <td class="text-gray-800">{{$pengecekan->nama_kendaraan}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Kode Asset:</td>
                                        <td class="text-gray-800">{{$pengecekan->kode_asset}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">No. Pol:</td>
                                        <td class="text-gray-800">{{$pengecekan->no_polisi}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Km/Pengecekan:</td>
                                        <td class="text-gray-800">{{$pengecekan->km_kendaraan}} Km</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Merk:</td>
                                        <td class="text-gray-800">{{$pengecekan->merk}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Tipe:</td>
                                        <td class="text-gray-800">{{$pengecekan->jenis}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Penggerak:</td>
                                        <td class="text-gray-800">{{$pengecekan->jenis_penggerak}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Bahan Bakar:</td>
                                        <td class="text-gray-800">{{$pengecekan->bahan_bakar}}</td>
                                    </tr>
                                    <!--end::Row-->
                                </table>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
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

    <!--begin::Modal Repair-->
    <div class="modal fade" id="kt_modal_repair_accept" tabindex="-1" aria-hidden="true">
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
                            <h1 class="mb-3">Persetujuan Perbaikan</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="form-group d-flex mb-8 row" id="id_approval">
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">NO. Pengecekan</label>
                                <input type="text" class="form-control form-control-solid"
                                    value="VC_{{$pengecekan->id_pengecekan}}" disabled />
                                <input type="hidden" class="form-control form-control-solid"
                                    value="{{$pengecekan->id_pengecekan}}" name="id_pengecekan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Tanggal Persetujuan</label>
                                <input type="date" class="form-control form-control-solid" value="{{date('Y-m-d')}}"
                                    disabled />
                                <input type="hidden" class="form-control form-control-solid" name="tgl_persetujuan"
                                    id="tgl_persetujuan" value="{{date('Y-m-d')}}" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">No. Work Order</label>
                                <input type="number" class="form-control form-control-solid" name="no_wo" id="no_wo"
                                    value="{{$latest_wo}}" />
                            </div>
                        </div>
                        <div class="form-group  mb-8 row" id="id_reparation">
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Pilih Dealer</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Dealer" id="id_dealer"
                                    name="id_dealer">
                                    <option value="">Pilih Dealer</option>
                                    @foreach ($dealer as $dl)
                                    <option value="{{$dl->id_dealer}}">
                                        {{$dl->nama_dealer}} |
                                        @if ($dl->status_dealer == 'p')
                                        <span class="badge badge-light-primary">Perusahaan</span>
                                        @else
                                        <span class="badge badge-light-danger">Partner</span>
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Tanggal Mulai Perbaikan</label>
                                <input type="date" class="form-control form-control-solid" name="tgl_perbaikan"
                                    id="tgl_perbaikan" value="{{date('Y-m-d')}}" />
                            </div>
                            <div class="col-lg-4">
                                <label class="required fs-6 fw-bold mb-2">Tanggal Penyelesaian Perbaikan</label>
                                <input type="date" class="form-control form-control-solid" name="tgl_selesai"
                                    id="tgl_selesai" />
                            </div>
                        </div>
                        <div class="form-group  mb-8 row" id="id_components">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th>Komponen</th>
                                            <th>Kondisi</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        @foreach ($detail as $dp)
                                        <tr>
                                            <td>{{$dp->jenis}}</td>
                                            <td>
                                                @if($dp->kondisi == 'b')
                                                <span class="badge badge-light-success">Baik/Normal</span>
                                                @else
                                                <span class="badge badge-light-danger">Rusak/Tidak Normal</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($dp->keterangan != null)
                                                {{$dp->keterangan}}
                                                @else
                                                ----
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
                            <button type="reset" id="kt_modal_repair_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_repair_submit" class="btn btn-primary">
                                <span class="indicator-label">Kirim</span>
                                <span class="indicator-progress">Mohon Tunggu...
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

    <!--begin::Modal - Reject-->
    <div class="modal fade" id="kt_modal_reject" tabindex="-1" aria-hidden="true">
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
                    <form id="kt_modal_reject_form" class="form"
                        action="{{route('repair.reject', $pengecekan->id_pengecekan)}}" method="POST">
                        @csrf
                        {{-- @method('PUT') --}}
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h1 class="mb-3">Penolakan Perbaikan</h1>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="required fs-6 fw-bold mb-2">NO. Pengecekan</label>
                            <input type="text" class="form-control form-control-solid"
                                value="VC_{{$pengecekan->id_pengecekan}}" disabled />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Deskripsi Penolakan</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Jelaskan Penolakan Perbaikan"></i>
                            </label>
                            <!--end::Label-->
                            <textarea name="keterangan_penolakan" class="form-control form-control-solid"
                                placeholder="Tuliskan Penolakan Perbaikan"></textarea>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_reject_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_modal_reject_submit" class="btn btn-primary">
                                <span class="indicator-label">Kirim</span>
                                <span class="indicator-progress">Mohon Tunggu Sebentar...
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
    <!--end::Modal - Reject-->

</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";

    var KTModalUncheck = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_repair_form")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_repair_form"),
                    t = document.getElementById("kt_modal_repair_submit"),
                    e = document.getElementById("kt_modal_repair_cancel"),
                    n = FormValidation.formValidation(a, {
                        fields: {
                                tgl_persetujuan: {
                                    validators: {
                                        notEmpty: {
                                            message: "Tanggal persetujuan harus diisi"
                                        }
                                    }
                                },
                                no_wo: {
                                    validators: {
                                        notEmpty: {
                                            message: "No. WO harus diisi"
                                        }
                                    }
                                },
                                id_dealer: {
                                    validators: {
                                        notEmpty: {
                                            message: "Dealer harus dipilih"
                                        }
                                    }
                                },
                                tgl_perbaikan: {
                                    validators: {
                                        notEmpty: {
                                            message: "Tgl. mulai perbaikan harus diisi"
                                        }
                                    }
                                },
                                tgl_selesai: {
                                    validators: {
                                        notEmpty: {
                                            message: "Tgl. penyelesaian perbaikan harus diisi"
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
                                    text: "Persetujuan perbaikan berhasil disimpan, data tidak bisa dikembalikan!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, saya mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function (t) {
                                    a.submit()
                                    t.isConfirmed && o.hide()
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Maaf, ada beberapa error terdeteksi!",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, saya mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })),
                    e.addEventListener("click", (function (t) {
                        t.preventDefault(), Swal.fire({
                            text: "Anda yakin membatalkan persetujuan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Iya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function (t) {
                            t.value ? (a.reset(), o.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Persetujuan anda belum dibatalkan",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, saya mengerti!",
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

    var KTModalNewTarget = function () {
        var t, e, n, a, o, i;
        return {
            init: function () {
                (i = document.querySelector("#kt_modal_reject")) && (o = new bootstrap.Modal(i),
                    a = document.querySelector("#kt_modal_reject_form"),
                    t = document.getElementById("kt_modal_reject_submit"),
                    e = document.getElementById("kt_modal_reject_cancel"),
                    n = FormValidation.formValidation(a, {
                        fields: {
                            keterangan_penolakan: {
                                validators: {
                                    notEmpty: {
                                        message: "Keterangan penolakan harus diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 255,
                                        message: "Maksimal 225 karakter."
                                        // }
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    }),
                    t.addEventListener("click", (function (e) {
                        e.preventDefault(), n && n.validate().then((function (e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Penolakan berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, saya mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function (t) {
                                    a.submit()
                                    t.isConfirmed && o.hide()
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Maaf, ada beberapa error terdeteksi.",
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
                            text: "Apakah anda yakin membatalkan penolakan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Iya, batalkan!",
                            cancelButtonText: "Tidak, kembali!",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function (t) {
                            t.value ? (a.reset(), o.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Penolakan anda belum dibatalka!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, saya mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })))
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function () {
        KTModalNewTarget.init()
    }));



</script>
@endpush
