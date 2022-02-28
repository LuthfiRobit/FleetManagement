@extends('layouts.backend.main')

@section('title','Laporan Kinerja Driver | Detail')

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
                        <span class="card-label fw-bolder fs-3 mb-1">DETAIL LAPORAN KINERJA DRIVER</span>
                        {{-- <span class="text-muted mt-1 fw-bold fs-7">Driver : </span> --}}
                    </h3>
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
                                <h2 class="fw-bolder">KRITERIA PENILAIAN</h2>
                            </div>
                            <!--begin::Card title-->
                            <div class="card-toolbar">
                                <div class=" bg-light-primary rounded border-primary border border-dashed p-2">
                                    <i class="bi bi-star-fill fs-2x" style="color:#ffad0f"></i>
                                </div>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Stats-->
                                {{-- <div class="flex-grow-1 card-p pb-0">
                                    <div class="d-flex flex-stack flex-wrap">
                                        <div class="me-2">
                                            <a href="#" class="text-dark text-hover-primary fw-bolder fs-3">Generate
                                                Reports</a>
                                            <div class="text-muted fs-7 fw-bold">Finance and accounting reports</div>
                                        </div>
                                        <div class="fw-bolder fs-3 text-primary">$24,500</div>
                                    </div>
                                </div> --}}
                                <!--end::Stats-->
                                <!--begin::Title-->
                                <h5 class="mb-4">Chart:</h5>
                                <!--end::Title-->
                                <!--begin::Chart-->
                                <div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary"
                                    style="height: 150px"></div>
                                <!--end::Chart-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Detail:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <!--begin::Table wrapper-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table
                                        class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                        <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                            <tr class="text-start text-muted text-uppercase gs-0">
                                                <th class="min-w-100px">Kriteria</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fs-6 fw-bold text-gray-600">
                                            @forelse ($rating as $rt)
                                            <tr>
                                                <td>{{$rt->pertanyaan}} ?</td>
                                                <td>
                                                    @for ($i = 0; $i < $rt->nilai; $i++)
                                                        <i class="bi bi-star-fill fs-2x" style="color:#ffad0f"></i>
                                                        @endfor
                                                </td>
                                            </tr>
                                            @empty
                                            <tr class="text-center">
                                                <td colspan="1" class="text-center">Belum ada penilaian</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table wrapper-->
                                <!--end::Row-->
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
                                    <div class="symbol symbol-60px symbol-circle me-3">
                                        <img alt="Pic" src="{{url('assets/backend/assets/media/avatars/150-4.jpg')}}" />
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
                                            class="fw-bold text-gray-600 text-hover-primary">{{$driver->no_tlp}}</a>
                                        <!--end::Email-->
                                        <span class="badge badge-light-primary">{{$driver->nama_departemen}}</span>
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
                            <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                <!--begin::Row-->
                                <tr class="">
                                    <td class="text-gray-400">History Perjalanan:</td>
                                    <td class="text-gray-800">{{$perjalanan}} kali</td>
                                </tr>
                                <tr class="">
                                    <td class="text-gray-400">History Pembatalan:</td>
                                    <td class="text-gray-800">{{$pembatalan}} kali</td>
                                </tr>
                                <tr class="">
                                    <td class="text-gray-400">History Non Aktif:</td>
                                    <td class="text-gray-800">{{$nonaktif}} kali</td>
                                </tr>
                            </table>
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
    {{-- @foreach ($rating as $r)
    {{$r->nilai}}
    @endforeach --}}
    <!--end::Post-->
</div>
@endsection

@push('scripts')
{{-- <script src="{{ url('assets/backend/assets/js/custom/widgets.js') }}"></script> --}}
<script text="text/javascript">
    "use strict";
    $(function () {
        var e = document.querySelectorAll(".mixed-widget-7-chart");
        [].slice.call(e).map((function (e) {
            var t = parseInt(KTUtil.css(e, "height"));
            if (e) {
                var a = e.getAttribute("data-kt-chart-color"),
                    o = KTUtil.getCssVariableValue("--bs-gray-800"),
                    s = KTUtil.getCssVariableValue("--bs-gray-300"),
                    r = KTUtil.getCssVariableValue("--bs-" + a),
                    i = KTUtil.getCssVariableValue("--bs-light-" + a);
                new ApexCharts(e, {
                    series: [{
                        name: "<i class='bi bi-star-fill fs-2x' style='color:#ffad0f'></i>",
                        data:  [@foreach ($rating as $r){{$r->nilai}},@endforeach]
                    }],
                    chart: {
                        fontFamily: "inherit",
                        type: "area",
                        height: t,
                        toolbar: {
                            show: !1
                        },
                        zoom: {
                            enabled: !1
                        },
                        sparkline: {
                            enabled: !0
                        }
                    },
                    plotOptions: {},
                    legend: {
                        show: !1
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    fill: {
                        type: "solid",
                        opacity: 1
                    },
                    stroke: {
                        curve: "smooth",
                        show: !0,
                        width: 3,
                        colors: [r]
                    },
                    xaxis: {
                        categories: [@foreach ($rating as $r)"{{substr($r->pertanyaan, 13, 30)}}",@endforeach],
                        axisBorder: {
                            show: !1
                        },
                        axisTicks: {
                            show: !1
                        },
                        labels: {
                            show: !1,
                            style: {
                                colors: o,
                                fontSize: "12px"
                            }
                        },
                        crosshairs: {
                            show: !1,
                            position: "front",
                            stroke: {
                                color: s,
                                width: 1,
                                dashArray: 3
                            }
                        }
                        // tooltip: {
                        //     enabled: !0,
                        //     formatter: void 0,
                        //     offsetY: 0,
                        //     style: {
                        //         fontSize: "12px"
                        //     }
                        // }
                    },
                    yaxis: {
                        min: 0,
                        max: 6,
                        labels: {
                            show: !1,
                            style: {
                                colors: o,
                                fontSize: "12px"
                            }
                        }
                    },
                    states: {
                        normal: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        hover: {
                            filter: {
                                type: "none",
                                value: 0
                            }
                        },
                        active: {
                            allowMultipleDataPointsSelection: !1,
                            filter: {
                                type: "none",
                                value: 0
                            }
                        }
                    },
                    tooltip: {
                        style: {
                            fontSize: "12px"
                        },
                        y: {
                            formatter: function (e) {
                                return "---" + e + "---"
                            }
                        }
                    },
                    colors: [i],
                    markers: {
                        colors: [i],
                        strokeColor: [r],
                        strokeWidth: 3
                    }
                }).render()
            }
        }))
    });
</script>
@endpush
