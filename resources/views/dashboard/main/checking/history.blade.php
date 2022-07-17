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
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bolder">HISTORY PENGECEKAN DRIVER</h2>
                    </div>
                    <!--begin::Card title-->
                    <div class="card-toolbar">
                        <div class=" bg-light-primary rounded border-primary border border-dashed p-2">
                            <i class="bi bi-star-fill fs-2x" style="color:#ffad0f"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!--begin::Layout-->
            <div class="d-flex flex-column">
                <!--begin::Content-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 mt-3">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2 class="fw-bolder">Filter By</h2>
                        </div>
                        <!--begin::Card title-->
                        <div class="card-toolbar">
                            <form action="">
                                 <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-4">
                                        <label class=" fs-6 fw-bold mt-2">Harian</label>
                                        <input class="form-check-input mt-2 ps-2" type="radio" name="status" id="status" value="h" {{ request()->get('status') == 'h' ? "checked" : "" }} />
                                    </div>
                                    <div class="col-lg-4">
                                       <input type="date" class="form-control form-control-solid"
                                                    placeholder="Pick a date" name="tgl_awal" id="tgl_awal" value="{{request()->get('tgl_awal')}}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="date" class="form-control form-control-solid"
                                                    placeholder="Pick a date" name="tgl_akhir"  id="tgl_akhir" value="{{request()->get('tgl_akhir')}}"/>
                                    </div>
                                </div>
                                <div class="form-group d-flex mb-8 row">
                                    <div class="col-lg-3">
                                        <label class="fs-6 fw-bold mt-2">Bulanan</label>
                                        <input class="form-check-input mt-2 ps-2" type="radio" name="status" id="status" value="b" {{ request()->get('status') == 'b' ? "checked" : "" }} />
                                    </div>
                                    <div class="col-lg-4">
                                        <input type="month" class="form-control form-control-solid"
                                                    placeholder="Pick a date" name="bulan"  id="bulan" value="{{request()->get('bulan')}}"/>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="submit" id="kt_modal_new_target_submit" class="btn btn-primary">
                                            <span class="indicator-label">Proses</span>
                                        </button>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" id="kt_modal_new_target_cancel" class="btn btn-light ms-2 me-3" onclick="location.href='{{route('check.history.driver')}}';">Reset</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
                             <div id="kt_apexcharts_3" style="height: 350px;"></div>
                            {{-- <div class="mixed-widget-7-chart card-rounded-bottom" data-kt-chart-color="primary"
                                style="height: 150px"></div> --}}
                            <!--end::Chart-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Section-->
                        <div class="mb-10">
                            <!--begin::Title-->
                            <h5 class="mb-4">List History Pengecekan Driver:</h5>
                            <!--end::Title-->
                            <!--begin::Details-->
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table container-->
                                <table id="kt_datatable_example_5"
                                    class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4 display responsive nowr">
                                    <thead>
                                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                                            <th>No</th>
                                            <th>Nama Driver</th>
                                            <th>No. Tlp</th>
                                            <th>Jumlah Pengecekan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history->sortByDesc('jumlah') as $h)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$h->nama_driver}}</td>
                                            <td>{{$h->no_tlp}}</td>
                                            <td>{{$h->jumlah}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!--end::Table container-->
                            </div>
                            <!--end::Table wrapper-->
                            <!--end::Row-->
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Content-->
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
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
{{-- <script src="{{ url('assets/backend/assets/js/custom/widgets.js') }}"></script> --}}
<script text="text/javascript">
    "use strict";
    $(document).ready(function () {
        $("#kt_datatable_example_5").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom":
                "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    });


    $(function () {

        $('input:radio').change(
            function(){
                if($(this).val() == 'h'){
                    $('input[type=date]').attr('required', true);
                    $('input[type=date]').attr('disabled', false);
                    $('input[type=month]').attr('disabled', true);
                }else{
                    $('input[type=date]').attr('disabled', true);
                    $('input[type=month]').attr('disabled', false);
                    $('input[type=month]').attr('required', true);
                }
            }
        );

        var element = document.getElementById('kt_apexcharts_3');

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-gray-200');
        var baseColor = KTUtil.getCssVariableValue('--bs-info');
        var lightColor = KTUtil.getCssVariableValue('--bs-light-info');

        if (!element) {
            return;
        }

        var options = {
            series: [{
                name: 'History',
                // data: [30, 40, 40, 90, 90, 70, 70]
                data: [@foreach ($history as $h){{$h->jumlah}},@endforeach]
            }],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {

            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: 'solid',
                opacity: 1
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseColor]
            },
            xaxis: {
                // categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                categories: [@foreach ($history as $h)"{{$h->nama_driver}}",@endforeach],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                },
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: baseColor,
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    formatter: undefined,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return '' + val + ' pengecekan'
                    }
                }
            },
            colors: [lightColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: baseColor,
                strokeWidth: 3
            }
        };

        var chart = new ApexCharts(element, options);
        chart.render();
    });
</script>
@endpush
