@extends('layouts.backend.main')

@section('title','Master | Driver')

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
                        <span class="card-label fw-bolder fs-3 mb-1">Edit Data Driver</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{$driver->no_badge}} |
                            {{$driver->nama_driver}}
                            @if ($driver->status_driver == 'y')
                            <span class="badge badge-light-primary">Aktif</span>
                            @elseif($driver->status_driver == 't')
                            <span class="badge badge-light-danger">Non Aktif</span>
                            @else
                            <span>----</span>
                            @endif
                        </span>

                    </h3>
                    <div class="card-toolbar">
                        <!--begin::Add-->
                        <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end">
                            <!--begin::Svg Icon | path: icons/duotune/technology/teh004.svg-->
                            <span class="svg-icon svg-icon-3">
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </span>
                            <!--end::Svg Icon-->Actions
                        </button>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="{{route('dashboard.driver.status.aktif', $driver->id_driver)}}"
                                    class="menu-link px-3">Aktifkan</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class=" menu-item px-3">
                                <a href="{{route('dashboard.driver.status.nonaktif', $driver->id_driver)}}"
                                    class="menu-link px-3">Non Aktifkan</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Add-->

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
                            <h5 class="mb-1">PESAN</h5>
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
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#kt_driver_umum">Data Umum</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab"
                                href="#kt_driver_sim">Sim</a>
                        </li>
                        <!--end:::Tab item-->
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true"
                                data-bs-toggle="tab" href="#kt_driver_privasi">Privasi</a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->
                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_driver_umum" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <div class="card-title flex-column">
                                        <h3 class="mb-1">Edit Data Umum</h3>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body p-9 pt-4">
                                    <!--begin::Form-->
                                    <form id="kt_modal_new_target_form" class="form"
                                        action="{{ route('dashboard.driver.update', $driver->id_driver)}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        @if ($errors->any())
                                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                                            <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                                                <i class="bi bi-exclamation-triangle fs-1"></i>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <div class="d-flex flex-column">
                                                <h4 class="mb-1 text-danger">This is an alert</h4>
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
                                        <!--begin::Input group-->

                                        <div class="form-group d-flex mb-8 row">
                                            <div class="col-lg-6">
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required">NO BADGE</span>
                                                </label>
                                                <!--end::Label-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Masukkan NO BADGE" name="no_badge"
                                                    value="{{$driver->no_badge}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required">Nama Driver</span>
                                                </label>
                                                <!--end::Label-->
                                                <input type="text" class="form-control form-control-solid"
                                                    placeholder="Masukkan Nama Driver" name="nama_driver"
                                                    value="{{$driver->nama_driver}}" />
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-8 row">
                                            <div class="col-lg-6">
                                                <label class="required fs-6 fw-bold mb-2">Departemen</label>
                                                <select class="form-select form-select-solid" data-control="select2"
                                                    data-hide-search="true" data-placeholder="Pilih Departemen"
                                                    id="id_departemen" name="id_departemen">
                                                    <option value="">Pilih Status</option>
                                                    @foreach ($departemen as $dt)
                                                    <option value="{{$dt->id_departemen}}" {{$dt->id_departemen ==
                                                        $driver->id_departemen ? 'selected' :
                                                        ''}}>{{$dt->nama_departemen}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required">Alamat</span>
                                                </label>
                                                <textarea name="alamat" class="form-control form-control-solid"
                                                    placeholder="Masukkan Alamat Driver">{{$driver->alamat}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex mb-8 row">
                                            <div class="col-lg-6">
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required">Usia</span>
                                                </label>
                                                <!--end::Label-->
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Masukkan Usia" name="umur" value="{{$driver->umur}}" />
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                                    <span class="required">No. Tlpn</span>
                                                </label>
                                                <!--end::Label-->
                                                <input type="number" class="form-control form-control-solid"
                                                    placeholder="Masukkan No. Tlpn" name="no_tlp"
                                                    value="{{$driver->no_tlp}}" />
                                            </div>
                                        </div>

                                        <!--end::Input group-->
                                        <!--begin::Actions-->
                                        <div class="text-center mt-3">
                                            <button type="reset" id="kt_modal_new_target_cancel"
                                                class="btn btn-light me-3">Cancel</button>
                                            <button type="submit" id="kt_modal_new_target_submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Submit</span>
                                                <span class="indicator-progress">Please wait...
                                                    <span
                                                        class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            </button>
                                        </div>
                                        <!--end::Actions-->
                                    </form>
                                    <!--end:Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end:::Tab pane-->
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show " id="kt_driver_sim" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card card-flush mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header mt-6">
                                    <div class="card-title flex-column">
                                        <h3 class="mb-1">Detail SIM</h3>
                                    </div>
                                    <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-trigger="hover" title=""
                                        data-bs-original-title="Tekan untuk menambah driver">
                                        <button type="button" class="btn btn-sm btn-light btn-active-primary"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_sim">
                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <i class="bi bi-plus fs-3"></i>
                                                Tambah SIM
                                            </span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body p-9 pt-4">
                                    <!--begin::Row-->
                                    <div class="row g-10">
                                        @forelse ($detailSim as $ds)
                                        <!--begin::Col-->
                                        <div class="col-md-4">
                                            <!--begin::Hot sales post-->
                                            <div class="card-xl-stretch me-md-6 ">
                                                <!--begin::Overlay-->
                                                <a class="d-block overlay rounded border-primary border border-dashed"
                                                    data-fslightbox="lightbox-hot-sales"
                                                    href="{{url('/assets/img_sim/'.$ds->foto_sim)}}">
                                                    <!--begin::Image-->
                                                    <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-175px"
                                                        style="background-image:url('{{url('/assets/img_sim/'.$ds->foto_sim)}}')">
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Action-->
                                                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                        <i class="bi bi-eye-fill fs-2x text-white"></i>
                                                    </div>
                                                    <!--end::Action-->
                                                </a>
                                                <!--end::Overlay-->
                                                <!--begin::Body-->
                                                <div class="mt-5 text-center">
                                                    <!--begin::Text-->
                                                    <div class="fw-bold fs-5 text-dark mt-3">{{$ds->nama_sim}}</div>
                                                    <button type="button" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-trigger="hover"
                                                        data-bs-original-title="Tekan untuk menghapus SIM"
                                                        class="btn remove btn-sm btn-icon btn-active-color-primary"
                                                        data-id="{{$ds->id_detail_sim}}">
                                                        <i class="bi bi-trash fs-1"></i>
                                                    </button>
                                                    <!--end::Text-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Hot sales post-->
                                        </div>
                                        <!--end::Col-->
                                        @empty

                                        <div
                                            class="bg-light-primary rounded border-primary border border-dashed p-2 text-center">
                                            <h3 class="mb-1">Belum Ada SIM, Silahkan Tambahkan atau Hubungi Driver Untuk
                                                Menambahkan Secara Pribadi!
                                            </h3>
                                        </div>
                                        @endforelse
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->

                        </div>
                        <!--end:::Tab pane-->
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade" id="kt_driver_privasi" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <h2>Edit Privasi</h2>
                                    </div>
                                    <!--end::Card title-->
                                    <div class="card-toolbar " data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-trigger="hover" title=""
                                        data-bs-original-title="Tekan untuk mereset semua username dan password driver">
                                        <a href="{{ route('dashboard.driver.password.reset', $driver->id_driver) }}"
                                            class="btn btn-sm btn-light btn-active-primary">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                            <span class="svg-icon svg-icon-3">
                                                <i class="bi bi-bootstrap-reboot"></i>

                                            </span>
                                            <!--end::Svg Icon-->Reset Username Password
                                        </a>
                                    </div>
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed gy-5"
                                            id="kt_table_users_login_session">
                                            <!--begin::Table body-->
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>Username</td>
                                                    <td>{{$driver->user}}</td>
                                                    <td class="text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_username">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <i class="bi bi-pencil-square fs-6"></i>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Password</td>
                                                    <td>********</td>
                                                    <td class="text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_password">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <i class="bi bi-pencil-square fs-6"></i>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>KTP</td>
                                                    <td>---</td>
                                                    <td class="text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_ktp">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <i class="bi bi-pencil-square fs-6"></i>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr>
                                                {{-- <tr>
                                                    <td>SIM</td>
                                                    <td>---</td>
                                                    <td class="text-end">
                                                        <button type="button"
                                                            class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#kt_modal_update_sim">
                                                            <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                            <span class="svg-icon svg-icon-3">
                                                                <i class="bi bi-pencil-square fs-6"></i>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </button>
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--begin::Body-->
            </div>
        </div>
        <!--end::Container-->
    </div>

    <!--begin::Modal - Update username-->
    <div class="modal fade" id="kt_modal_update_username" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Update Username</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
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
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_username_form" class="form"
                        action="{{route('dashboard.driver.username.update', $driver->id_driver)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Notice-->
                        <!--begin::Notice-->
                        <div
                            class="notice d-flex bg-light-primary rounded border-primary border border-dashed mb-9 p-6">
                            <!--begin::Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                            <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="black" />
                                    <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)"
                                        fill="black" />
                                    <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--end::Icon-->
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-stack flex-grow-1">
                                <!--begin::Content-->
                                <div class="fw-bold">
                                    <div class="fs-6 text-gray-700">Tolong isi dengan username yang mudah diingat contoh
                                        nama depan anda.</div>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Notice-->
                        <!--end::Notice-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold form-label mb-2">
                                <span class="required">Username</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" placeholder="" name="user"
                                value="{{$driver->user}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Batal</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon Tunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update username-->

    <!--begin::Modal - Update password-->
    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Update Password</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
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
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_update_password_form" class="form" method="POST"
                        action="{{ route('dashboard.driver.password.update', $driver->id_driver) }}">
                        @csrf
                        @method('PUT')
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="required form-label fs-6 mb-2">Password Sekarang</label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="" name="current_password" autocomplete="off" />
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Input group-->
                        <div class="mb-10 fv-row" data-kt-password-meter="true">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Label-->
                                <label class="form-label fw-bold fs-6 mb-2">Password Baru</label>
                                <!--end::Label-->
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control form-control-lg form-control-solid" type="password"
                                        placeholder="" name="new_password" autocomplete="off" />
                                    <span
                                        class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                        data-kt-password-meter-control="visibility">
                                        <i class="bi bi-eye-slash fs-2"></i>
                                        <i class="bi bi-eye fs-2 d-none"></i>
                                    </span>
                                </div>
                                <!--end::Input wrapper-->
                                <!--begin::Meter-->
                                <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                    <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                </div>
                                <!--end::Meter-->
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Hint-->
                            <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &amp;
                                symbols.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="form-label fw-bold fs-6 mb-2">Konfirmasi Password Baru</label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="" name="confirm_password" autocomplete="off" />
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Batal</button>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Simpan</span>
                                <span class="indicator-progress">Mohon Tunggu...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Update password-->

    <!--begin::Modal - Update KTP-->
    <div class="modal fade" id="kt_modal_update_ktp" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="{{route('dashboard.driver.changeKtp.update',$driver->id_driver)}}"
                    id="kt_modal_update_user_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_update_user_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">Update KTP Driver</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Input group-->
                        {{-- <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">No. KTP</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" class="form-control form-control-solid"
                                placeholder="Masukkan Nomer KTP Driver" name="no_ktp" value="" />
                            <!--end::Input-->
                        </div> --}}
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="d-block fw-bold fs-6 mb-5">Foto KTP</label>
                            <!--end::Label-->

                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url({{url('assets/backend/assets/media/avatars/blank.png')}})">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-200px h-125px" @if ($driver->foto_ktp != null )
                                    style="background-image:url({{url('/assets/img_ktp/'.$driver->foto_ktp)}})"
                                    @else
                                    style="background-image:
                                    url({{url('assets/backend/assets/media/avatars/blank.png')}})"
                                    @endif>
                                </div>
                                <!--end::Preview existing avatar-->

                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ganti KTP">
                                    <i class="bi bi-pencil-fill fs-7"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="foto_ktp" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->

                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan KTP">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->

                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus KTP">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel">Batal</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Mohon Tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Update KTP-->

    <!--begin::Modal - Update SIM-->
    <div class="modal fade" id="kt_modal_update_sim" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Form-->
                <form class="form" action="{{route('dashboard.driver.sim.add',$driver->id_driver)}}"
                    id="kt_modal_update_sim_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <!--begin::Modal header-->
                    <div class="modal-header" id="kt_modal_update_user_header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bolder">Update SIM Driver</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black" />
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                    <!--begin::Modal body-->
                    <div class="modal-body py-10 px-lg-17">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Jenis SIM</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                    title="Anda Bisa Isi di Lain Hari"></i></label>
                            <select class="form-select form-select-solid" data-control="select2"
                                data-hide-search="false" data-placeholder="Pilih Jenis SIM" id="id_jenis_sim"
                                name="id_jenis_sim">
                                <option value="">Pilih Jenis SIM</option>
                                @foreach ($jenisSim as $js)
                                <option value="{{$js->id_jenis_sim}}" data-nama="{{$js->nama_sim}}">{{$js->nama_sim}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class=" fv-row mb-7">
                            <!--begin::Label-->
                            <label class="d-block fw-bold fs-6 mb-5">Foto SIM</label>
                            <!--end::Label-->

                            <!--begin::Image input-->
                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url({{url('assets/backend/assets/media/avatars/blank.png')}})">
                                <!--begin::Preview existing avatar-->
                                <div class="image-input-wrapper w-200px h-125px" style="background-image:
                                            url({{url('assets/backend/assets/media/avatars/blank.png')}})">
                                </div>
                                <!--end::Preview existing avatar-->

                                <!--begin::Label-->
                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    title="Tambah Foto SIM">
                                    <i class="bi bi-pencil-fill fs-7"></i>

                                    <!--begin::Inputs-->
                                    <input type="file" name="foto_sim" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                    <!--end::Inputs-->
                                </label>
                                <!--end::Label-->

                                <!--begin::Cancel-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan SIM">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Cancel-->

                                <!--begin::Remove-->
                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus SIM">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <!--end::Remove-->
                            </div>
                            <!--end::Image input-->
                        </div>
                    </div>
                    <!--end::Modal body-->
                    <!--begin::Modal footer-->
                    <div class="modal-footer flex-center">
                        <!--begin::Button-->
                        <button type="reset" class="btn btn-light me-3"
                            data-kt-users-modal-action="cancel">Batal</button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Mohon Tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                    </div>
                    <!--end::Modal footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
    <!--end::Modal - Update SIM-->

    <!--end::Post-->
</div>
@endsection

@push('scripts')
{{-- <script src="{{url('assets/backend/assets/js/custom/modals/new-target.js')}}">
</script> --}}
<script text="text/javascript">
    "use strict";
    //modal data umum
    var KTModalNewTarget = function () {
        var t, e, n, a, i;
        return {
            init: function () {
                (
                    a = document.querySelector("#kt_modal_new_target_form"),
                    t = document.getElementById("kt_modal_new_target_submit"),
                    e = document.getElementById("kt_modal_new_target_cancel")

                    , n = FormValidation.formValidation(a, {
                        fields: {
                            nama_driver: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Driver Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 45,
                                        message: "Nama Driver Maksimal 45 Karakter"
                                        // }
                                    }
                                }
                            },
                            no_badge: {
                                validators: {
                                    notEmpty: {
                                        message: "NO Badge Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 10,
                                        message: "NO Badge Maksimal 10 Karakter"
                                        // }
                                    }
                                }
                            },
                            id_departemen: {
                                validators: {
                                    notEmpty: {
                                        message: "Departemen Harus Dipilih"
                                    }
                                }
                            },
                            alamat: {
                                validators: {
                                    notEmpty: {
                                        message: "Alamat Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 60,
                                        message: "Alamat Maksimal 45 Karakter"
                                        // }
                                    }
                                }
                            },
                            umur: {
                                validators: {
                                    notEmpty: {
                                        message: "Usia Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 3,
                                        message: "Usia Maksimal 3 Karakter"
                                        // }
                                    }
                                }
                            },
                            no_tlp: {
                                validators: {
                                    notEmpty: {
                                        message: "No. Tlpn Harus Diisi"
                                    },
                                    stringLength: {
                                        // options: {
                                        max: 12,
                                        message: "No. Tlpn Maksimal 12 Karakter"
                                        // }
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".row",
                                // eleInvalidClass: "",
                                // eleValidClass: ""
                            })
                        }
                    }),
                    t.addEventListener("click", (function (e) {
                        e.preventDefault(), n && n.validate().then((function (e) {
                            console.log("validated!"), "Valid" == e ? (t.setAttribute("data-kt-indicator", "on"), t.disabled = !0, setTimeout((function () {
                                t.removeAttribute("data-kt-indicator"), t.disabled = !1, Swal.fire({
                                    text: "Formulir telah berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function (t) {
                                    a.submit()
                                    t.isConfirmed && o.hide()
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Maaf, sepertinya ada beberapa kesalahan yang terdeteksi, silakan coba lagi.",
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
                            text: "Apakah Anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function (t) {

                            t.value ?
                            (a.reset(), window.location.href = "{{ route('dashboard.driver.index')}}") : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir Anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
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
    //modal username
    var KTUsersUpdateEmail = function() {
        const t = document.getElementById("kt_modal_update_username"),
            e = t.querySelector("#kt_modal_update_username_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            user: {
                                validators: {
                                    notEmpty: {
                                        message: "Username Harus Diisi"
                                    },
                                    stringLength: {
                                    // options: {
                                    max: 15,
                                    message: "Username Maksimal 15 Karakter"
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
                    });
                    t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }));
                    const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                    i.addEventListener("click", (function(t) {
                        t.preventDefault(), o && o.validate().then((function(t) {
                            console.log("validated!"), "Valid" == t && (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function() {
                                i.removeAttribute("data-kt-indicator"), i.disabled = !1, Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function(t) {
                                    e.submit()
                                    t.isConfirmed && n.hide()
                                }))
                            }), 2e3))
                        }))
                    }))
                })()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTUsersUpdateEmail.init()
    }));
    //modal password
    var KTUsersUpdatePassword = function() {
        const t = document.getElementById("kt_modal_update_password"),
            e = t.querySelector("#kt_modal_update_password_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            current_password: {
                                validators: {
                                    notEmpty: {
                                        message: "Current password is required"
                                    }
                                }
                            },
                            new_password: {
                                validators: {
                                    notEmpty: {
                                        message: "The password is required"
                                    },
                                    callback: {
                                        message: "Please enter valid password",
                                        callback: function(t) {
                                            if (t.value.length > 0) return validatePassword()
                                        }
                                    }
                                }
                            },
                            confirm_password: {
                                validators: {
                                    notEmpty: {
                                        message: "The password confirmation is required"
                                    },
                                    identical: {
                                        compare: function() {
                                            return e.querySelector('[name="new_password"]').value
                                        },
                                        message: "The password and its confirm are not the same"
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
                    });
                    t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Are you sure you would like to cancel?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Yes, cancel it!",
                            cancelButtonText: "No, return",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Your form has not been cancelled!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }));
                    const a = t.querySelector('[data-kt-users-modal-action="submit"]');
                    a.addEventListener("click", (function(t) {
                        t.preventDefault(), o && o.validate().then((function(t) {
                            console.log("validated!"), "Valid" == t && (a.setAttribute("data-kt-indicator", "on"), a.disabled = !0, setTimeout((function() {
                                a.removeAttribute("data-kt-indicator"), a.disabled = !1, Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function(t) {
                                    e.submit()
                                    t.isConfirmed && n.hide()
                                }))
                            }), 2e3))
                        }))
                    }))
                })()
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTUsersUpdatePassword.init()
    }));
    //modal ktp
    var KTUsersUpdateDetails = function() {
        const t = document.getElementById("kt_modal_update_ktp"),
            e = t.querySelector("#kt_modal_update_user_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                    (() => {
                        var o = FormValidation.formValidation(e, {
                            fields: {
                                no_ktp: {
                                    validators: {
                                        notEmpty: {
                                            message: "No. KTP Harus Diisi"
                                        },
                                        stringLength: {
                                            // options: {
                                            max: 16,
                                            message: "No. KTP Maksimal 16 Karakter"
                                            // }
                                        }
                                    }
                                },
                                'foto_ktp': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Silahkan pilih foto ktp'
                                        },
                                        file: {
                                            extension: 'jpg,jpeg,png',
                                            type: 'image/jpeg,image/png',
                                            message: 'File tidak falid'
                                        },
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
                        });
                        t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        }));
                        const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                        i.addEventListener("click", (function(t) {
                            t.preventDefault(), o && o.validate().then((function(t) {
                                console.log("validated!"), "Valid" == t && (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function() {
                                    i.removeAttribute("data-kt-indicator"), i.disabled = !1, Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then((function(t) {
                                        e.submit()
                                        t.isConfirmed && n.hide()
                                    }))
                                }), 2e3))
                            }))
                        }))
                    })()
                }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTUsersUpdateDetails.init()
    }));
    //modal sim
    var KTUsersUpdateSIM = function() {
        const t = document.getElementById("kt_modal_update_sim"),
            e = t.querySelector("#kt_modal_update_sim_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                    (() => {
                        var o = FormValidation.formValidation(e, {
                            fields: {
                                id_jenis_sim: {
                                    validators: {
                                        notEmpty: {
                                            message: "Jenis SIM Harus Diisi"
                                        }
                                    }
                                },
                                'foto_sim': {
                                    validators: {
                                        notEmpty: {
                                            message: 'Silahkan pilih foto sim'
                                        },
                                        file: {
                                            extension: 'jpg,jpeg,png',
                                            type: 'image/jpeg,image/png',
                                            message: 'File tidak falid'
                                        },
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
                        });
                        t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                            t.preventDefault(), Swal.fire({
                                text: "Are you sure you would like to cancel?",
                                icon: "warning",
                                showCancelButton: !0,
                                buttonsStyling: !1,
                                confirmButtonText: "Yes, cancel it!",
                                cancelButtonText: "No, return",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: "btn btn-active-light"
                                }
                            }).then((function(t) {
                                t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                    text: "Your form has not been cancelled!.",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                })
                            }))
                        }));
                        const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                        i.addEventListener("click", (function(t) {
                            t.preventDefault(), o && o.validate().then((function(t) {
                                console.log("validated!"), "Valid" == t && (i.setAttribute("data-kt-indicator", "on"), i.disabled = !0, setTimeout((function() {
                                    i.removeAttribute("data-kt-indicator"), i.disabled = !1, Swal.fire({
                                        text: "Form has been successfully submitted!",
                                        icon: "success",
                                        buttonsStyling: !1,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then((function(t) {
                                        e.submit()
                                        t.isConfirmed && n.hide()
                                    }))
                                }), 2e3))
                            }))
                        }))
                    })()
                }
        }
    }();
    KTUtil.onDOMContentLoaded((function() {
        KTUsersUpdateSIM.init()
    }));
    //hapus sim
    $(function () {
        var replyBtns = document.querySelectorAll('button.remove');
        for (var i = 0; i < replyBtns.length; i++) {
        replyBtns[i].addEventListener('click', function(e) {
            var  t;
            t = $(this);
            $.ajax({
                type: 'POST',
                url: '{{route("dashboard.driver.sim.remove")}}',
                data: {
                    '_token': '{{csrf_token()}}',
                    'id_detail_sim': $(this).data('id')
                    // 'jml':$(this).val()
                },
                datatype: 'JSON',
                success: function (response) {
                    Swal.fire(
                        'Berhasil!',
                        'SIM Terhapus',
                        'success'
                        )
                    t.parent().parent().remove();
                    console.log(response);
                },
                error: function (response) {
                    // t.parent().parent().remove();
                    // alert('Gagal Menghapus');
                    Swal.fire(
                        'Gagal!',
                        'Tidak dapat mengapus SIM',
                        'error'
                        )
                    console.log(response);
                }
            });
            // alert($(this).data('id'));
            // this.parentNode.parentNode.remove(this.parentNode);
        }, false);
        }
    });
</script>
@endpush
