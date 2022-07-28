@extends('layouts.backend.main')

@section('title','Penugasan Driver | Edit')
@section('style-on-this-page-only')
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <div class="card mb-5 mb-xl-8">
                <div class="card-body py-3">
                    <!--begin::Form-->
                    <form id="kt_form_accept" class="form" method="POST" enctype="multipart/form-data"
                        action="{{route('checking.serviceorder.update')}}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h3 class="mb-2 mt-2">Edit Penugasan</h3>
                            <h4 class="mb-2 mt-2">SO_{{$serviceorder->no_so}} | PEMESAN {{$pemesan->nama_pemesan}} | DEPT {{$pemesan->nama_departemen}}</span>
                                <!--end::Title-->
                                @if ($errors->any())
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                    <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                                        <i class="bi bi-exclamation-triangle fs-1"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Errors</h4>
                                        <span>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                                @endif
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="form-group d-flex mb-8 row">
                            <input type="hidden" value="{{$serviceorder->id_service_order}}" name="id_service_order" />
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tujuan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat tujuan" name="tmp_tujuan" value="{{$serviceorder->tujuan}}" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-5">
                                    <span class="required">Status Tujuan</span>
                                </label>
                                <!--end::Label-->
                                <div class="radio-inline d-flex justify-content-between">
                                    <label class="radio">
                                    <input type="radio" name="status_tujuan" class="form-check-input" value="l"
                                     required {{ $serviceorder->status_tujuan == 'l' ? 'checked' : '' }}>
                                    <span>Lokal</span>
                                    </label>
                                    <label class="radio">
                                    <input type="radio" name="status_tujuan" class="form-check-input" value="o"
                                    {{ $serviceorder->status_tujuan == 'o' ? 'checked' : '' }}>
                                    <span>Out Of Town</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat penjemputan" name="tmp_penjemputan" value="{{$serviceorder->tempat_penjemputan}}" required />
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Agenda</span>
                                </label>
                                <!--end::Label-->
                                <textarea type="text" class="form-control form-control-solid"
                                    placeholder="Isi agenda penugasan" name="agenda" required>{{$serviceorder->keterangan}}</textarea>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Jam Penjemputan</span>
                                </label>
                                <!--end::Label-->
                                <input type="time" class="form-control form-control-solid"
                                    placeholder="Isi jam penjemputan" name="jam_penjemputan" value="{{Carbon\Carbon::parse($serviceorder->jam_penjemputan)->format('H:i')}}" required />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tgl. Penjemputan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver dan kendaraan yang tersedia"></i>
                                </label>
                                <!--end::Label-->
                                <input type="date" class="form-control form-control-solid"
                                    placeholder="Isi tanggal penjemputan" name="tgl_penjemputan" id="tgl_penjemputan"
                                    value="{{$serviceorder->tgl_penjemputan}}"
                                    required />
                            </div>
                        </div>
                        <div class="form-group mb-8 row">
                            <div class="col-lg-4">
                                <label class="fs-6 fw-bold mb-2">
                                    <span class="required">Kendaraan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan kendaraan yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Kendaraan" id="id_kendaraan"
                                    name="id_kendaraan" required>
                                     @foreach ($kendaraan as $kd)
                                        <option value="{{$kd->id_kendaraan}}" {{ $serviceorder->id_kendaraan == $kd->id_kendaraan ? 'selected' : '' }}>
                                            {{$kd->no_polisi}} | {{$kd->nama_kendaraan}} | {{$kd->alokasi}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="fs-6 fw-bold mb-2">
                                    <span class="required">Driver</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Isi tgl. penjemputan untuk menampilkan driver yang tersedia"></i>
                                </label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Driver" id="id_driver"
                                    name="id_driver" required>
                                    @foreach ($driver as $dr)
                                        <option value="{{$dr->id_driver}}" {{ $serviceorder->id_driver == $dr->id_driver ? 'selected' : '' }}>{{$dr->nama_driver}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kembali</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Isi tempat kembali driver" name="tmp_kembali" value="{{$serviceorder->kembali}}" required />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-3">
                            <button type="reset" id="kt_button_cancel" class="btn btn-light me-3">Batal</button>
                            <button type="submit" id="kt_button_submit" class="btn btn-primary">
                                <span class="indicator-label">Edit</span>
                                <span class="indicator-progress">Mohon Tunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
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
    $(function () {

        $('#tgl_penjemputan').on('change', function () {
            var tgl_penjemputan = $(this).val();
            // console.log(tgl_penjemputan);
            $.ajax({
                url : '{{route("driver.select")}}',
                method : 'GET',
                data : {
                    'tgl_penjemputan' : $(this).val()
                },
                dataType : 'json',
                success : function (result) {
                    // console.log(result);
                    // console.log(result.Success);
                    // console.log(result.Kendaraan);
                    // console.log(result.Driver);
                    if (result.Success == true) {
                        $('#id_driver').empty();
                        $('#id_kendaraan').empty();
                        var kendaraan = result.Kendaraan;
                        var driver = result.Driver;
                        var alokasi;
                        $.each(kendaraan, function (key, item) {
                            if (item.alokasi == null) {
                                alokasi = '---';
                            } else {
                                alokasi = item.alokasi;
                            }
                            $('#id_kendaraan').append($('<option></option>').attr('value', item.id_kendaraan).text(item.no_polisi+' | '+item.nama_kendaraan+' | '+alokasi));
                                // $('option', this).each(function () {
                                //     if ($(this).html() == item.nama_driver) {
                                //         $(this).attr('selected', 'selected')
                                //     };
                                // });
                        });
                        $.each(driver, function (key, item) {
                            $('#id_driver').append($('<option></option>').attr('value', item.id_driver).text(item.nama_driver));
                                // $('option', this).each(function () {
                                //     if ($(this).html() == item.nama_driver) {
                                //         $(this).attr('selected', 'selected')
                                //     };
                                // });
                        })
                    } else {
                        alert(result.Message);
                        $('#id_driver').empty();
                        $('#id_kendaraan').empty();
                    }
                }
            });
        });
    });
</script>
@endpush
