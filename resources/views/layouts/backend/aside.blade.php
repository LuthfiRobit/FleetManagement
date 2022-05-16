<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="https://www.pomi.co.id/">
            <img alt="Logo" src="{{url('assets/img_logo/logo_pomi3.png')}}" class="h-50px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="black" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
            data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">
                <div class="menu-item">
                    <div class="menu-content pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Dashboard</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}"
                        href="{{route('dashboard')}}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Halaman Utama</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'dashboard.monitoring.driver' ? 'active' : '' }}"
                        href="{{route('dashboard.monitoring.driver')}}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect x="2" y="2" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2" fill="black" />
                                    <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2" fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Monitoring Driver</span>
                    </a>
                </div>
                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Main</span>
                    </div>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'checking.serviceorder' ? 'active' : '' }}"
                        href="{{ route('checking.serviceorder') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Penugasan Driver</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'status.main' ? 'active' : '' }}"
                        href="{{ route('status.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Status Driver</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'assign.main' ? 'active' : '' }}"
                        href="{{ route('assign.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Status Penugasan Driver</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'assign.main.batal' ? 'active' : '' }}"
                        href="{{ route('assign.main.batal') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Pengajuan Pembatalan Tugas</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'rating.main' ? 'active' : '' }}"
                        href="{{ route('rating.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Laporan Kinerja Driver</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'check.main' ? 'active' : '' }}"
                        href="{{ route('check.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Laporan Pengecekan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'repair.main' ? 'active' : '' }}"
                        href="{{ route('repair.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Laporan Perbaikan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'accident.main' ? 'active' : '' }}"
                        href="{{ route('accident.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Laporan Kecelakaan</span>
                    </a>
                </div>
                {{-- <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'biaya.main' ? 'active' : '' }}"
                        href="{{ route('biaya.main') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-concierge-bell"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Tagihan Biaya Penugasan</span>
                    </a>
                </div> --}}

                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Data Master</span>
                    </div>
                </div>
                {{-- @dd(Route::currentRouteName() == 'dashboard.kendaraan.main.index') --}}
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::currentRouteName() == 'dashboard.kendaraan.main.index' ||
                    Route::currentRouteName() == 'dashboard.bahanbakar.index' || Route::currentRouteName() == 'dashboard.kendaraan.merk.index' || Route::currentRouteName() == 'dashboard.kendaraan.jenis.index' || Route::currentRouteName() == 'dashboard.kendaraan.jenis_alokasi.index'
                     ? 'show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                        fill="black" />
                                    <path
                                        d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">KENDARAAN</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.kendaraan.main.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.kendaraan.main.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Kendaraan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.bahanbakar.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.bahanbakar.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Bahan Bakar</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.kendaraan.merk.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.kendaraan.merk.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Merk Kendaraan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.kendaraan.jenis.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.kendaraan.jenis.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Jenis Kendaraan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.kendaraan.jenis_alokasi.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.kendaraan.jenis_alokasi.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Jenis Alokasi</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ Route::currentRouteName() == 'dashboard.driver.index' ||
                Route::currentRouteName() == 'dashboard.sim.index' ? 'show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                        fill="black" />
                                    <path
                                        d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">DRIVER</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.driver.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.driver.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Driver</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.sim.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.sim.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Jenis SIM</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ Route::currentRouteName() == 'dashboard.petugas.main.index' ||
                Route::currentRouteName() == 'dashboard.petugas.departemen.index' || Route::currentRouteName() == 'dashboard.petugas.jabatan.index' || Route::currentRouteName() == 'dashboard.dealer.index' ? 'show' : '' }}">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path opacity="0.3"
                                        d="M21 22H14C13.4 22 13 21.6 13 21V3C13 2.4 13.4 2 14 2H21C21.6 2 22 2.4 22 3V21C22 21.6 21.6 22 21 22Z"
                                        fill="black" />
                                    <path
                                        d="M10 22H3C2.4 22 2 21.6 2 21V3C2 2.4 2.4 2 3 2H10C10.6 2 11 2.4 11 3V21C11 21.6 10.6 22 10 22Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">DEPARTEMEN</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.petugas.main.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.petugas.main.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Petugas</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.petugas.departemen.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.petugas.departemen.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Departemen</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.petugas.jabatan.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.petugas.jabatan.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Jabatan</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link {{ Route::currentRouteName() == 'dashboard.dealer.index' ? 'active' : '' }}"
                                href="{{ route('dashboard.dealer.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Data Dealer</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="menu-item">
                    <div class="menu-content pt-8 pb-2">
                        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Setting</span>
                    </div>
                </div>

                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'dashboard.pengecekan.kriteria.index' ? 'active' : '' }}"
                        href="{{ route('dashboard.pengecekan.kriteria.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-bars"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Kriteria Pengecekan</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'dashboard.kriteria_rating.index' ? 'active' : '' }}"
                        href="{{ route('dashboard.kriteria_rating.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-warehouse"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Kriteria Rating</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link {{ Route::currentRouteName() == 'dashboard.jenis_pengeluaran.index' ? 'active' : '' }}"
                        href="{{ route('dashboard.jenis_pengeluaran.index') }}">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                            <span class="svg-icon svg-icon-2">
                                <i class="fa fa-warehouse"></i>
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Jenis Pengeluaran</span>
                    </a>
                </div>
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->
    <!--begin::Footer-->
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <a href="#" class="btn btn-custom btn-primary w-100" data-bs-toggle="tooltip" data-bs-trigger="hover"
            data-bs-dismiss-="click" title="200+ in-house components and 3rd-party plugins">
            <span class="btn-label">Manual &amp; Description</span>
            <!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
            <span class="svg-icon btn-icon svg-icon-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3"
                        d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM15 17C15 16.4 14.6 16 14 16H8C7.4 16 7 16.4 7 17C7 17.6 7.4 18 8 18H14C14.6 18 15 17.6 15 17ZM17 12C17 11.4 16.6 11 16 11H8C7.4 11 7 11.4 7 12C7 12.6 7.4 13 8 13H16C16.6 13 17 12.6 17 12ZM17 7C17 6.4 16.6 6 16 6H8C7.4 6 7 6.4 7 7C7 7.6 7.4 8 8 8H16C16.6 8 17 7.6 17 7Z"
                        fill="black" />
                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </a>
    </div>
    <!--end::Footer-->
</div>
<!--end::Aside-->
