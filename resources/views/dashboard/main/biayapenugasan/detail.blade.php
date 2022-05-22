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

            <form action="{{ route('biaya.insert')}}" method="post">
                @csrf
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bolder fs-3 mb-1">Tagihan Biaya Penugasan
                                SO_{{$biaya->no_so}}</span>
                            <span class="text-muted mt-1 fw-bold fs-7">Oleh Driver : {{$biaya->nama_driver}}</span>
                        </h3>
                        {{-- <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-trigger="hover" title="" data-bs-original-title="Tekan untuk mecetak tagihan biaya">
                            <button type="button" class="btn btn-sm btn-light btn-active-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                <span class="svg-icon svg-icon-3">
                                </span>
                                <!--end::Svg Icon-->Cetak Tagihan
                            </button>
                        </div> --}}

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
                                    <th>Jenis Pengeluaran</th>
                                    <th>Nominal</th>
                                    <th>Bukti</th>
                                    <th>Acc Service Controller</th>
                                    <th>Tgl. Acc</th>
                                    <th>Acc BKM</th>
                                    <th>Tgl. Acc</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_biaya as $db)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$db->nama_jenis}}</td>
                                    <td>Rp. {{$db->nominal}}</td>
                                    <td>
                                        <a href="{{url('/assets/img_biaya/'.$db->bukti)}}">
                                            <img src="{{url('/assets/img_biaya/'.$db->bukti)}}" class="rounded"
                                                alt="..." width="50">
                                        </a>
                                        <br>
                                        @if ($db->keterangan != null)
                                        <span>{{$db->keterangan}}</span>
                                        @else
                                        ---
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->id_petugas == 5)
                                        @if($status == 'scmc')
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_sc == 't' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_sc{{$db->id_detail_biaya}}"
                                                disabled>Terima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_sc == 'tl' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_sc{{$db->id_detail_biaya}}"
                                                disabled>Tolak</label>
                                        </div>
                                        @else
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc-sc" type="radio"
                                                name="acc_sc[{{$db->id_detail_biaya}}]"
                                                id="acc_sc{{$db->id_detail_biaya}}" value="t" {{$db->acc_sc == 't' ?
                                            'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="acc_sc{{$db->id_detail_biaya}}">Terima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc-sc" type="radio"
                                                name="acc_sc[{{$db->id_detail_biaya}}]"
                                                id="acc_sc{{$db->id_detail_biaya}}" value="tl" {{$db->acc_sc == 'tl' ?
                                            'checked' : '' }} >
                                            <label class="form-check-label"
                                                for="acc_sc{{$db->id_detail_biaya}}">Tolak</label>
                                        </div>
                                        @endif
                                        @else
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_sc == 't' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_sc{{$db->id_detail_biaya}}"
                                                disabled>Terima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_sc == 'tl' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_sc{{$db->id_detail_biaya}}"
                                                disabled>Tolak</label>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($db->tgl_cek_sc != null)
                                        {{$db->tgl_cek_sc}}
                                        @else
                                        ---
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::user()->id_petugas == 4)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc-mc" type="radio"
                                                name="acc_mc[{{$db->id_detail_biaya}}]"
                                                id="acc_mc{{$db->id_detail_biaya}}" value="t" {{$db->acc_mc == 't' ?
                                            'checked' : '' }} required>
                                            <label class="form-check-label"
                                                for="acc_mc{{$db->id_detail_biaya}}">Terima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input acc-mc" type="radio"
                                                name="acc_mc[{{$db->id_detail_biaya}}]"
                                                id="acc_mc{{$db->id_detail_biaya}}" value="tl" {{$db->acc_mc == 'tl' ?
                                            'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="acc_mc{{$db->id_detail_biaya}}">Tolak</label>
                                        </div>
                                        @else
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_mc == 't' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_mc{{$db->id_detail_biaya}}"
                                                disabled>Terima</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" {{$db->acc_mc == 'tl' ?
                                            'checked' : '' }} disabled>
                                            <label class="form-check-label" for="acc_mc{{$db->id_detail_biaya}}"
                                                disabled>Tolak</label>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($db->tgl_cek_mc != null)
                                        {{$db->tgl_cek_mc}}
                                        @else
                                        ---
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--end::Table container-->
                    </div>

                    <!--begin::Body-->
                </div>
                <div class="card-body py-2 text-end">
                    @if (Auth::user()->id_petugas == 5)
                    <button type="submit" class=" btn btn-sm btn-primary w-150px" id="memek_acc_sc">SIMPAN APPROVAL
                        SC</button>
                    @elseif (Auth::user()->id_petugas == 4)
                    <button type="submit" class=" btn btn-sm btn-primary w-150px" id="memek_acc_mc">SIMPAN APPROVAL
                        BKM</button>
                    @else
                    ----
                    @endif
                </div>
                <div class="card-body py-2">
                    <table
                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                        <thead>
                            <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                <th>TOTAL ACC SC</th>
                                <th>Rp. {{$total_sc}}
                                </th>
                                <th>TOTAL ACC BKM</th>
                                <th>Rp. {{$total_mc}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </form>
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
    $(function(){

    });
</script>
@endpush
