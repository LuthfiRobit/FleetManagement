@extends('layouts.backend.main')

@section('title','Penugasan Driver | Terima')
@section('style-on-this-page-only')

<style>
    /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
    /* #map {
        height: 80%;
        padding-left: 20px;
        padding-right: 20px;
    } */

    /* Optional: Makes the sample page fill the window. */
    /* html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    } */

    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #origin-input,
    #destination-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 200px;
    }

    #origin-input:focus,
    #destination-input:focus {
        border-color: #4d90fe;
    }

    #mode-selector {
        color: #fff;
        background-color: #4d90fe;
        margin-left: 12px;
        padding: 5px 11px 0px 11px;
    }

    #mode-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    .map-container {
        overflow: hidden;
        padding-bottom: 45%;
        position: relative;
        height: 0;
    }

    .map-container #map {
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        position: absolute;
    }
</style>
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
                    <form id="kt_form_accept" class="form"
                        action="{{route('checking.serviceorder.accept', $so->id_so)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <!--begin::Title-->
                            <h3 class="mb-2 mt-2">Buat Penugasan</h3>
                            <span class="text-muted mt-1 fw-bold fs-7">Pemesan : {{$so->petugas}} | Jabatan :
                                {{$so->jabatan}} | {{$so->departemen}}</span>
                            <!--end::Title-->
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
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->

                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Kendaraan</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Kendaraan" id="id_kendaraan"
                                    name="id_kendaraan">
                                    <option value="">Pilih Kendaraan</option>
                                    @foreach ($kendaraan as $kd)
                                    <option value="{{$kd->id_kendaraan}}" data-sim="{{$kd->id_jenis_sim}}">
                                        {{$kd->nama_kendaraan}} | {{$kd->no_polisi}} |
                                        {{$kd->sim}} | {{$kd->alokasi}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label class="required fs-6 fw-bold mb-2">Driver</label>
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="false" data-placeholder="Pilih Driver" id="id_driver"
                                    name="id_driver">
                                    {{-- <option value="">Pilih Driver</option> --}}
                                </select>
                            </div>
                        </div>
                        <div class="form-group d-flex mb-8 row">
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tempat Penjemputan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Pilih Penjemputan dengan MAP di Atas"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Otomatis Sesuai dengan Map " name="tmp_jemput" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Tujuan</span>
                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                        title="Pilih Tujuan dengan MAP di Atas"></i>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Otomatis Sesuai dengan Map" name="tmp_tujuan" />
                            </div>
                            <div class="col-lg-4">
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Kembali</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid"
                                    placeholder="Masukkan Kembali ke?" name="kembali" />
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-3">
                            <button type="reset" id="kt_button_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="kt_button_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
            </div>
            <div class="card mb-5 mb-xl-8">
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">Informasi Service Order</span>
                        <span class="text-muted mt-1 fw-bold fs-7">Penjemputan : {{$so->tmp_jemput}} | Tujuan :
                            {{$so->tmp_tujuan}}</span>
                    </h3>
                </div>

                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div style="display: none">
                        <input id="origin-input" value="{{$so->tmp_jemput}}" class="controls" type="text"
                            placeholder="Tempat Penjemputan" />

                        <input id="destination-input" value="{{$so->tmp_tujuan}}" class="controls" type="text"
                            placeholder="Tempat Tujuan" />

                        <div id="mode-selector" class="controls">
                            <input type="radio" name="type" id="changemode-walking" checked="checked" />
                            <label for="changemode-walking">Walking</label>

                            <input type="radio" name="type" id="changemode-transit" />
                            <label for="changemode-transit">Transit</label>

                            <input type="radio" name="type" id="changemode-driving" />
                            <label for="changemode-driving">Driving</label>
                        </div>
                    </div>
                    <div id="map-container-google-1" class="z-depth-1-half map-container">
                        <div id="map"></div>
                    </div>
                </div>
                <!--begin::Body-->
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
    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

function initMap() {
    const map = new google.maps.Map(document.getElementById("map"), {
        mapTypeControl: false,
        center: {
            lat: -7.712207659465981,
            lng: 113.57765855871503
        },
        zoom: 15,
    });

    new AutocompleteDirectionsHandler(map);
}

class AutocompleteDirectionsHandler {
    map;
    originPlaceId;
    destinationPlaceId;
    travelMode;
    directionsService;
    directionsRenderer;
    constructor(map) {
        this.map = map;
        this.originPlaceId = "";
        this.destinationPlaceId = "";
        this.travelMode = google.maps.TravelMode.WALKING;
        this.directionsService = new google.maps.DirectionsService();
        this.directionsRenderer = new google.maps.DirectionsRenderer();
        this.directionsRenderer.setMap(map);

        const originInput = document.getElementById("origin-input");
        const destinationInput = document.getElementById("destination-input");
        const modeSelector = document.getElementById("mode-selector");
        // Specify just the place data fields that you need.
        const originAutocomplete = new google.maps.places.Autocomplete(
            originInput, {
                fields: ["place_id"]
            }
        );
        // Specify just the place data fields that you need.
        const destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput, {
                fields: ["place_id"]
            }
        );

        this.setupClickListener(
            "changemode-walking",
            google.maps.TravelMode.WALKING
        );
        this.setupClickListener(
            "changemode-transit",
            google.maps.TravelMode.TRANSIT
        );
        this.setupClickListener(
            "changemode-driving",
            google.maps.TravelMode.DRIVING
        );
        this.setupPlaceChangedListener(originAutocomplete, "ORIG");
        this.setupPlaceChangedListener(destinationAutocomplete, "DEST");
        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(
            destinationInput
        );
        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(modeSelector);
    }
    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    setupClickListener(id, mode) {
        const radioButton = document.getElementById(id);

        radioButton.addEventListener("click", () => {
            this.travelMode = mode;
            this.route();
        });
    }
    setupPlaceChangedListener(autocomplete, mode) {
        autocomplete.bindTo("bounds", this.map);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();

            if (!place.place_id) {
                window.alert("Please select an option from the dropdown list.");
                return;
            }

            if (mode === "ORIG") {
                this.originPlaceId = place.place_id;
            } else {
                this.destinationPlaceId = place.place_id;
            }

            this.route();
        });
    }
    route() {
        if (!this.originPlaceId || !this.destinationPlaceId) {
            return;
        }

        const me = this;

        this.directionsService.route({
                origin: {
                    placeId: this.originPlaceId
                },
                destination: {
                    placeId: this.destinationPlaceId
                },
                travelMode: this.travelMode,
            },
            (response, status) => {
                if (status === "OK") {
                    me.directionsRenderer.setDirections(response);
                } else {
                    window.alert("Directions request failed due to " + status);
                }
            }
        );
    }
}

$(function () {
    $('#id_kendaraan').on('change', function () {
       var id_sim =  $(this).val();
        // alert($(this).find(':selected').data('sim'));
        $.ajax({
            // url: 'http://127.0.0.1:8000/driver/select?id_sim='+id_sim+'&id_so='+{{$so->id_so}},
            url : '{{route("driver.select")}}',
            method: 'GET',
            // error: (result) => $.Notification.error(result),
            data: {
                // 'id_sim': $(this).val(),
                'id_sim': $(this).find(':selected').data('sim'),
                'id_so': {{$so->id_so}}
                },
            dataType: 'json',
            success: function (result) {
                console.log(result);
                console.log(result.Success);
                console.log(result.Driver);
                if (result.Success == true) {
                    $('#id_driver').empty();
                    var driver = result.Driver;
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
                }
            }
        })
    });
    // $('#id_driver').on('change', function () {
    //     id_sim =  $(this).val();
    //     alert(id_sim);
    // });
});

var KTFormAccept = function () {
    var t, e, n, a, i;
    return {
        init: function () {
            (
                a = document.querySelector("#kt_form_accept"),
                t = document.getElementById("kt_button_submit"),
                e = document.getElementById("kt_button_cancel")
                , n = FormValidation.formValidation(a, {
                    fields: {
                        id_kendaraan: {
                            validators: {
                                notEmpty: {
                                    message: "Kendaraan Harus Dipilih"
                                }
                            }
                        },
                        id_driver: {
                            validators: {
                                notEmpty: {
                                    message: "Driver Harus Dipilih"
                                }
                            }
                        },
                        tmp_jemput: {
                            validators: {
                                notEmpty: {
                                    message: "Penjemputan Harus Diisi, Silahkan Eksekusi Field Di G. Maps"
                                }
                            }
                        },
                        tmp_tujuan: {
                            validators: {
                                notEmpty: {
                                    message: "Tujuan Harus Diisi, Silahkan Eksekusi Field Di G. Maps"
                                }
                            }
                        },
                        kembali: {
                            validators: {
                                notEmpty: {
                                    message: "Kembali Harus Diisi"
                                }
                            }
                        },
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
                        (a.reset(), window.location.href = "{{route('checking.serviceorder.detail',$so->id_so)}}") : "cancel" === t.dismiss && Swal.fire({
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
    KTFormAccept.init()
}));
</script>
@endpush
