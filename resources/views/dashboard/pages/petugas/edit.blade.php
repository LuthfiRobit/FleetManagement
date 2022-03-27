@extends('layouts.backend.main')

@section('title','Master | Petugas')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 ">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Edit Data Petugas</span>
                        {{-- <span class="text-muted mt-1 fw-bold fs-7">{{$petugas->no_badge}} |
                            {{$petugas->nama_lengkap}}</span> --}}
                    </h3>
                </div>
                <!--end::Header-->
            </div>

            @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
                <span class="svg-icon svg-icon-2hx svg-icon-danger me-2">
                    <i class="bi bi-exclamation-triangle fs-1"></i>
                </span>
                <!--end::Svg Icon-->
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Pesan Error</h4>
                    <span>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </span>
                </div>
                <!--begin::Close-->
                <button type="button"
                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                    data-bs-dismiss="alert">
                    <i class="bi bi-x fs-1 text-danger"></i>
                </button>
                <!--end::Close-->
            </div>
            @endif
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
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-xl-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->
                            <!--begin::User Info-->
                            <div class="d-flex flex-center flex-column py-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    <img @if ($petugas->foto_petugas != null)
                                    src="{{url('/assets/img_petugas/'.$petugas->foto_petugas)}}"
                                    @else
                                    src="{{url('/assets/backend/assets/media/avatars/blank.png')}}"
                                    @endif
                                    alt="image" />
                                </div>
                                <button type="button" class="btn btn-icon btn-light-primary w-30px h-30px"
                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_profil">
                                    <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <i class="bi bi-pencil-square fs-6"></i>
                                    </span>
                                    <!--end::Svg Icon-->
                                </button>
                                <!--end::Avatar-->
                                <!--begin::Name-->
                                <a
                                    class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-3">{{$petugas->nama_lengkap}}</a>
                                <!--end::Name-->
                                <!--begin::Position-->
                                <div class="mb-9">
                                    <!--begin::Badge-->
                                    <div class="badge badge-lg badge-light-primary d-inline">
                                        {{$petugas->nama_departemen}}</div>
                                    <!--begin::Badge-->
                                </div>
                                <!--end::Position-->
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->
                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bolder rotate collapsible">Keamanan
                                </div>
                                <span data-bs-toggle="tooltip" data-bs-trigger="hover" title=""
                                    data-bs-original-title="Tekan untuk mereset username dan password pertugas">
                                    <a href="{{ route('dashboard.petugas.dashboard.petugas.main.password.reset', $petugas->id_petugas) }}"
                                        class="btn btn-sm btn-light-primary">
                                        <span class="svg-icon svg-icon-3">
                                            <i class="bi bi-bootstrap-reboot"></i>
                                        </span>
                                        Reset
                                    </a>
                                </span>
                            </div>
                            <!--end::Details toggle-->
                            <div class="separator"></div>
                            <!--begin::Details content-->
                            <div id="kt_user_view_details" class="">
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                    <!--begin::Row-->
                                    <tr>
                                        <td>Username :</td>
                                        <td>{{$petugas->user}}</td>
                                        <td class="text-end">
                                            <button type="button"
                                                class="btn btn-icon btn-light-primary w-30px h-30px ms-auto"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <i class="bi bi-pencil-square fs-6"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr>
                                        <td>Password :</td>
                                        <td>************</td>
                                        <td class="text-end">
                                            <button type="button"
                                                class="btn btn-icon btn-light-primary w-30px h-30px ms-auto"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <i class="bi bi-pencil-square fs-6"></i>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </button>
                                        </td>
                                    </tr>
                                    <!--end::Row-->
                                </table>
                                <!--end::Details-->
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">Data Umum</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body p-9 pt-4">
                            <!--begin::Form-->
                            <form id="kt_modal_new_target_form" class="form"
                                action="{{ route('dashboard.petugas.main.update', $petugas->id_petugas)}}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!--begin::Input group-->
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">No. Badge</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan No. Badge" name="no_badge"
                                            value="{{$petugas->no_badge}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="required fs-6 fw-bold mb-2">Departemen</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Departemen"
                                            id="id_departemen" name="id_departemen">
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($departemen as $dp)
                                            <option value="{{$dp->id_departemen}}" {{$petugas->id_departemen ==
                                                $dp->id_departemen ? 'selected' : ''}}>
                                                {{$dp->nama_departemen}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="required fs-6 fw-bold mb-2">Jabatan</label>
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="false" data-placeholder="Pilih Jabatan" id="id_jabatan"
                                            name="id_jabatan">
                                            <option value="">Pilih Jabatan</option>
                                            @foreach ($jabatan as $jb)
                                            <option value="{{$jb->id_jabatan}}" {{$petugas->id_jabatan ==
                                                $jb->id_jabatan ? 'selected' : ''}}>{{$jb->nama_jabatan}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Nama Petugas</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Nama Petugas" name="nama_lengkap"
                                            value="{{$petugas->nama_lengkap}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Tempat Lahir</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="text" class="form-control form-control-solid"
                                            placeholder="Masukkan Tempat Lahir" name="tempat_lahir"
                                            value="{{$petugas->tempat_lahir}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Tanggal Lahir</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="date" class="form-control form-control-solid"
                                            placeholder="Masukkan Tanggal Lahir" name="tgl_lahir"
                                            value="{{$petugas->tgl_lahir}}" />
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">No. Tlpn</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="number" class="form-control form-control-solid"
                                            placeholder="Masukkan No. Tlpn" name="no_tlp"
                                            value="{{$petugas->no_tlp}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Tanggal Mulai Kerja</span>
                                        </label>
                                        <!--end::Label-->
                                        <input type="date" class="form-control form-control-solid"
                                            placeholder="Masukkan Tanggal Mulai Kerja" name="tgl_mulai_kerja"
                                            value="{{$petugas->tgl_mulai_kerja}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                            <span class="required">Status</span>
                                        </label>
                                        <!--end::Label-->
                                        <select class="form-select form-select-solid" data-control="select2"
                                            data-hide-search="true" data-placeholder="Pilih Status" id="status"
                                            name="status">
                                            <option value="">Pilih Status</option>
                                            <option value="y" {{$petugas->status == 'y' ? 'selected' : ''}}>
                                                Aktif</option>
                                            <option value="t" {{$petugas->status == 't' ? 'selected' : ''}}>
                                                Nonaktif</option>
                                        </select>
                                    </div>
                                </div>

                                <!--end::Input group-->
                                <!--begin::Actions-->
                                <div class="text-center mt-3">
                                    <button type="reset" id="kt_modal_new_target_cancel"
                                        class="btn btn-light me-3">Batalkan</button>
                                    <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                        <span class="indicator-label">Simpan</span>
                                        <span class="indicator-progress">Mohon Tunggu...
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
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->
    </div>


    <!--begin::Modal - Update email-->
    <div class="modal fade" id="kt_modal_update_profil" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">Update Profil</h2>
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
                    <form id="kt_modal_update_profil_form" class="form"
                        action="{{route('dashboard.petugas.dashboard.petugas.profil.update', $petugas->id_petugas)}}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Input group-->
                        <div class="mb-7 fv-row text-center">
                            <!--begin::Label-->
                            <label class="fs-6 fw-bold mb-2">
                                <span>Foto Profil Petugas</span>
                                <i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip"
                                    title="Tipe file yang diizinkan: png, jpg, jpeg."></i>
                            </label>
                            <!--end::Label-->
                            <!--begin::Image input wrapper-->
                            <div class="mt-1">
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                    style="background-image: url({{url('/assets/backend/assets/media/avatars/blank.png')}})">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px"
                                        style="background-image: url({{url('/assets/img_petugas/'.$petugas->foto_petugas)}})">
                                    </div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Edit-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Ganti Profil">
                                        <i class="bi bi-pencil-fill fs-7"></i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="foto_petugas" id="foto_petugas"
                                            accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Edit-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Hapus Profil">
                                        <i class="bi bi-x fs-2"></i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                            </div>
                            <!--end::Image input wrapper-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Batalkan</button>
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
    <!--end::Modal - Update email-->

    <!--begin::Modal - Update email-->
    <div class="modal fade" id="kt_modal_update_email" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
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
                    <form id="kt_modal_update_email_form" class="form"
                        action="{{route('dashboard.petugas.dashboard.petugas.main.username.update', $petugas->id_petugas)}}"
                        method="POST" enctype="multipart/form-data">
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
                                value="{{$petugas->user}}" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Batalkan</button>
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
    <!--end::Modal - Update email-->
    <!--begin::Modal - Update password-->
    <div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered">
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
                        action="{{ route('dashboard.petugas.dashboard.petugas.main.password.update', $petugas->id_petugas) }}">
                        @csrf
                        @method('PUT')
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="required form-label fs-6 mb-2">Password Lama</label>
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
                            <div class="text-muted">Gunakan minimal 8 karakter dengan paduan huruf, angka &amp;
                                simbol.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-10">
                            <label class="form-label fw-bold fs-6 mb-2">Konfirmasik Password Baru</label>
                            <input class="form-control form-control-lg form-control-solid" type="password"
                                placeholder="" name="confirm_password" autocomplete="off" />
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3"
                                data-kt-users-modal-action="cancel">Batalkan</button>
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
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<script text="text/javascript">
    "use strict";
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
                        no_badge: {
                            validators: {
                                notEmpty: {
                                    message: "No. Badge Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 10,
                                    message: "No. Badge Maksimal 10 Karakter"
                                    // }
                                }
                            }
                        },
                        id_departemen: {
                            validators: {
                                notEmpty: {
                                    message: "Departemen Harus Diisi"
                                }
                            }
                        },
                        id_jabatan: {
                            validators: {
                                notEmpty: {
                                    message: "Jabatan Harus Diisi"
                                }
                            }
                        },
                        nama_lengkap: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Lengkap Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 45,
                                    message: "Nama Lengkap Maksimal 45 Karakter"
                                    // }
                                }
                            }
                        },
                        tempat_lahir: {
                            validators: {
                                notEmpty: {
                                    message: "Tempat Lahir Harus Diisi"
                                },
                                stringLength: {
                                    // options: {
                                    max: 20,
                                    message: "Tempat Lahir Maksimal 20 Karakter"
                                    // }
                                }
                            }
                        },
                        tgl_lahir: {
                            validators: {
                                notEmpty: {
                                    message: "Tanggal Lahir Harus Diisi"
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
                        },
                        tgl_mulai_kerja: {
                            validators: {
                                notEmpty: {
                                    message: "Tanggal Mulai Kerja Harus Diisi"
                                }
                            }
                        },
                        status: {
                            validators: {
                                notEmpty: {
                                    message: "Status Harus Diisi"
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
                                confirmButtonText: "Ok, mengerti!",
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
                            confirmButtonText: "Ok, mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        })
                    }))
                })),
                e.addEventListener("click", (function (t) {
                    t.preventDefault(), Swal.fire({
                        text: "Apakah anda yakin ingin membatalkan?",
                        icon: "warning",
                        showCancelButton: !0,
                        buttonsStyling: !1,
                        confirmButtonText: "Ya, batalkan!",
                        cancelButtonText: "Tidak, kembali",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then((function (t) {

                        t.value ?
                        (a.reset(), window.location.href = "{{ route('dashboard.petugas.main.index')}}") : "cancel" === t.dismiss && Swal.fire({
                            text: "Formulir anda belum dibatalkan!.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, mengerti!",
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


    var KTUsersUpdateProfil = function() {
        const t = document.getElementById("kt_modal_update_profil"),
            e = t.querySelector("#kt_modal_update_profil_form"),
            n = new bootstrap.Modal(t);
        return {
            init: function() {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            foto_petugas: {
                                validators: {
                                    notEmpty: {
                                        message: 'Silahkan pilih foto profil'
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
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
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
                                    text: "Formulir anda berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
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
        KTUsersUpdateProfil.init()
    }));

    var KTUsersUpdateEmail = function() {
        const t = document.getElementById("kt_modal_update_email"),
            e = t.querySelector("#kt_modal_update_email_form"),
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
                                    message: "Username maksimal 15 Karakter"
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
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
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
                                    text: "Formulir anda berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
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
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    })), t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click", (t => {
                        t.preventDefault(), Swal.fire({
                            text: "Apakah anda yakin ingin membatalkan?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ya, batalkan!",
                            cancelButtonText: "Tidak, kembali",
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: "btn btn-active-light"
                            }
                        }).then((function(t) {
                            t.value ? (e.reset(), n.hide()) : "cancel" === t.dismiss && Swal.fire({
                                text: "Formulir anda belum dibatalkan!.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
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
                                    text: "Formulir anda berhasil dikirim!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
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
</script>
@endpush
