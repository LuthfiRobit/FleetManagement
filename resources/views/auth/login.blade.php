<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Login</title>
    @include('layouts.backend.style')
    @yield('style-on-this-page-only')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Authentication - Sign-in -->
            <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
                style="background-image:url({{url('assets/backend/assets/media/illustrations/sketchy-1/14.png')}})">
                <!--begin::Content-->
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                    <!--begin::Logo-->
                    <a href="#" class="mb-12">
                        <img alt="Logo" src="{{url('assets/img_logo/logo_pomi1.png')}}" class="h-100px" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Wrapper-->
                    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST"
                            action="{{route('login.petugas')}}">
                            @csrf
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-dark mb-3">Login Fleet Manajemen</h1>
                                <!--end::Title-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-6 fw-bolder text-dark">Username</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg form-control-solid" type="text" name="user"
                                    autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack mb-2">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                    <!--end::Label-->
                                    <!--begin::Link-->
                                    <a href="#" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Input-->
                                <input class="form-control form-control-lg form-control-solid" type="password"
                                    name="password" autocomplete="off" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="text-center">
                                <!--begin::Submit button-->
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">Login</span>
                                    <span class="indicator-progress">Mohon Tunggu...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                                <!--end::Submit button-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <div class="d-flex flex-center flex-column-auto p-10">
                    <!--begin::Links-->
                    <div class="d-flex align-items-center fw-bold fs-6">
                        <a href="https://www.pomi.co.id/" class="text-muted text-hover-primary px-2">PT. POMI</a>
                        <a href="https://www.unuja.ac.id/" class="text-muted text-hover-primary px-2">UNUJA</a>
                        <a href="https://commitdev-id.vercel.app/" class="text-muted text-hover-primary px-2">Commit
                            Dev</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Authentication - Sign-in-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::Root-->
    <!--end::Main-->
    <script>
        var hostUrl = "{{url('assets/backend/assets/')}}";
    </script>
    <!--begin::Javascript-->
    <script src="{{ url('assets/backend/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{url('assets/backend/assets/js/scripts.bundle.js')}}"></script>
    <script text="text/javascipt">
        "use strict";
        var KTSigninGeneral = function () {
            var t, e, i;
            return {
                init: function () {
                    t = document.querySelector("#kt_sign_in_form"), e = document.querySelector("#kt_sign_in_submit"), i = FormValidation.formValidation(t, {
                        fields: {
                            user: {
                                validators: {
                                    notEmpty: {
                                        message: "Username harus diisi"
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: "Password harus diisi"
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row"
                            })
                        }
                    }), e.addEventListener("click", (function (n) {
                        n.preventDefault(), i.validate().then((function (i) {
                            "Valid" == i ? (e.setAttribute("data-kt-indicator", "on"), e.disabled = !0, setTimeout((function () {
                                e.removeAttribute("data-kt-indicator"), e.disabled = !1, Swal.fire({
                                    text: "Login anda akan diproses, jika gagal anda akan dikembalikan ke halaman login!",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, mengerti!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then((function (e) {
                                    t.submit()
                                    e.isConfirmed
                                }))
                            }), 2e3)) : Swal.fire({
                                text: "Maaf ada beberapa kesalahan, silhakan coba kembali.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, mengerti!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            })
                        }))
                    }))
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTSigninGeneral.init()
        }));
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
