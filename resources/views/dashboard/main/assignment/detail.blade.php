@extends('layouts.backend.main')

@section('title','Status Penugasan Driver | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL PENUGASAN DRIVER</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Driver : {{$detail->nama_driver}}</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{route('assign.export.pdf', $detail->id_do)}}" type="button"
                            class="btn btn-light-primary btn-sm">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="bi bi-file-pdf"></i>
                            </span>
                            <!--end::Svg Icon-->Export
                        </a>
                    </div>
                </div>
            </div>
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
                                <h2 class="fw-bolder">PERJALANAN</h2>
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                @if ($detail->status_do == 't')
                                <div class=" bg-light-primary rounded border-primary border border-dashed p-2">
                                    Diterima
                                </div>
                                @elseif ($detail->status_do == 'p')
                                <div class=" bg-light-warning rounded border-warning border border-dashed p-2">
                                    Dalam Perjalanan
                                </div>
                                @elseif ($detail->status_do == 's')
                                <div class=" bg-light-success rounded border-success border border-dashed p-2">
                                    Selesai
                                </div>
                                @elseif ($detail->status_do == 'c')
                                <div class=" bg-light-danger rounded border-danger border border-dashed p-2">
                                    Dibatalkan
                                </div>
                                @else
                                <div class=" bg-light-warning rounded border-warning border border-dashed p-2">
                                    Menunggu Konfirmasi
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
                                                <td class="text-gray-400 min-w-175px w-175px">No. Do:</td>
                                                <td class="text-gray-800 min-w-200px">DO_{{$detail->no_so}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Pemesan:</td>
                                                <td class="text-gray-800 min-w-200px">{{$detail->nama_petugas}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">No. Tlp:</td>
                                                <td class="text-gray-800">{{$detail->p_tlp}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tempat Penjemputan:</td>
                                                <td class="text-gray-800">{{$detail->tempat_penjemputan}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tempat Tujuan:</td>
                                                <td class="text-gray-800">{{$detail->tujuan}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tujuan Perjalanan:</td>
                                                <td class="text-gray-800">
                                                    {{$detail->keterangan}}
                                                </td>
                                            </tr>
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
                                                <td class="text-gray-400 min-w-175px w-175px">Tanggal Penjemputan:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    {{Carbon\Carbon::parse($detail->tgl_penugasan)->format('d F Y')}}
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Jam Penjemputan:</td>
                                                <td class="text-gray-800">
                                                    {{Carbon\Carbon::parse($detail->jam_berangkat)->format('H:i')}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tempat Kembali:</td>
                                                <td class="text-gray-800">{{$detail->kembali}}</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Status:</td>
                                                <td class="text-gray-800">
                                                    @if ($detail->status_do == 't')
                                                    <div class="badge badge-lg badge-light-primary d-inline">
                                                        Diterima
                                                    </div>
                                                    @elseif($detail->status_do == 'p')
                                                    <div class="badge badge-lg badge-light-warning d-inline">
                                                        Process
                                                    </div>
                                                    @elseif($detail->status_do == 's')
                                                    <div class="badge badge-lg badge-light-success d-inline">
                                                        Selesai
                                                    </div>
                                                    @elseif($detail->status_do == 'c')
                                                    <div class="badge badge-lg badge-light-danger d-inline">
                                                        Dibatalkan
                                                    </div>
                                                    @else
                                                    <div class="badge badge-lg badge-light-warning d-inline">
                                                        Menunggu Konfirmasi
                                                    </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Tgl. Selesai:</td>
                                                <td class="text-gray-800">
                                                    @if ($detail->tgl_selesai != null)
                                                    {{Carbon\Carbon::parse($detail->tgl_selesai)->format('d F Y')}}
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
                                <h5 class="mb-4">Keberangkatan:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Jam Awal:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($detail->waktu_start != null)
                                                    {{Carbon\Carbon::parse($detail->waktu_start)->format('H:i')}}
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Km Awal:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($detail->km_awal != null)
                                                    {{$detail->km_awal}}
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">BBM Awal:</td>
                                                <td class="text-gray-800">
                                                    @if ($detail->bbm_awal != null)
                                                    @if ($detail->bbm_awal == 'l')
                                                    Rendah
                                                    @elseif($detail->bbm_awal == 'm')
                                                    Medium
                                                    @elseif($detail->bbm_awal == 'f')
                                                    Penuh
                                                    @endif
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
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Jam Selesai:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($detail->waktu_finish != null)
                                                    {{Carbon\Carbon::parse($detail->waktu_finish)->format('H:i')}}
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Km Selesai:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    @if ($detail->km_akhir != null)
                                                    {{$detail->km_akhir}}
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">BBM Selesai:</td>
                                                <td class="text-gray-800">
                                                    @if ($detail->bbm_akhir != null)
                                                    @if ($detail->bbm_akhir == 'l')
                                                    Rendah
                                                    @elseif($detail->bbm_akhir == 'm')
                                                    Medium
                                                    @elseif($detail->bbm_akhir == 'f')
                                                    Penuh
                                                    @endif
                                                    @else
                                                    ---
                                                    @endif
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Ket. BBM:</td>
                                                <td class="text-gray-800">
                                                    @if ($detail->keterangan_bbm != null)
                                                    {{$detail->keterangan_bbm}}
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
                            <div class="mb-0">
                                <!--begin::Title-->
                                <h5 class="mb-4">Penumpang:</h5>
                                <!--end::Title-->
                                <!--begin::Product table-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr
                                                class="border-bottom border-gray-200 text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-150px">Nama Penumpang</th>
                                                <th>Jabatan</th>
                                                <th class="min-w-125px">No. Telepon</th>
                                                <th>Status</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-800">
                                            @foreach ($penumpang as $pn)
                                            <tr>
                                                <td>
                                                    <label class="w-150px">{{$pn->nama_penumpang}}</label>
                                                </td>
                                                <td>{{$pn->nama_jabatan}}</td>
                                                <td>{{$pn->no_tlp}}</td>
                                                <td>
                                                    {{-- {{$ds->status}} --}}
                                                    @if ($pn->status == 'y')
                                                        Lead
                                                    @else
                                                        Pass
                                                    @endif
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
                        data-kt-sticky-offset="{default: false, lg: '200px'}"
                        data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto"
                        data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>DRIVER</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div
                                        class="symbol symbol-60px symbol-circle me-3 border-primary border border-dashed">
                                        <img alt="Profil Driver {{$driver->nama_driver}}" @if ($driver->foto_driver !=
                                        null)
                                        src="{{url('assets/img_driver/'.$driver->foto_driver)}}"
                                        @else
                                        src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                        @endif />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-2">
                                            {{$driver->nama_driver}}
                                        </a>
                                        <!--end::Name-->
                                        <!--begin::Email-->
                                        <a href="#"
                                            class="fw-bold text-gray-600 text-hover-primary">{{$driver->d_tlp}}</a>
                                        <!--end::Email-->
                                        <span class="badge badge-light-primary">{{$driver->departemen}}</span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">KENDARAAN</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Nama:</td>
                                        <td class="text-gray-800">{{$detail->nama_kendaraan}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">No. Pol:</td>
                                        <td class="text-gray-800">{{$detail->no_polisi}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Warna:</td>
                                        <td class="text-gray-800">{{$detail->warna}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Merk:</td>
                                        <td class="text-gray-800">{{$detail->merk}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Jenis:</td>
                                        <td class="text-gray-800">{{$detail->jenis}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Penggerak:</td>
                                        <td class="text-gray-800">{{$detail->jenis_penggerak}}</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Bahan Bakar:</td>
                                        <td class="text-gray-800">{{$detail->bahan_bakar}}</td>
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
</div>
@endsection

@push('scripts')

<script text="text/javascript">
    "use strict";
</script>
@endpush
