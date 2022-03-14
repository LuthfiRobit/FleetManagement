@extends('layouts.backend.main')

@section('title','Dashboard | Monitoring Driver')
@section('style-on-this-page-only')
<link href="{{url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
    type="text/css" />
<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    /* #map {
        height: 100%;
    } */

    /* Optional: Makes the sample page fill the window. */
    /* html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    } */

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
                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1">MONITOR LOKASI DRIVER</span>
                        <span class="text-muted mt-1 fw-bold fs-7">{{$lokasi->count()}} Sedang Bertugas</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-3">
                    <div id="map-container-google-1" class="z-depth-1-half map-container">
                        <div id="map"></div>
                    </div>
                </div>
            </div>

        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
@endsection

@push('scripts')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('KEY_MAPS')}}
&callback=initMap&v=weekly" async></script>
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ url('assets/backend/assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ url('assets/backend/assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script text="text/javascipt">
    // The following example creates complex markers to indicate beaches near
    // Sydney, NSW, Australia. Note that the anchor is set to (0,32) to correspond
    // to the base of the flagpole.

    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 10,
            center: { lat: -7.712207659465981, lng: 113.57765855871503 },
        });

        setMarkers(map);
    }

    // Data for the markers consisting of a name, a LatLng and a zIndex for the
    // order in which these markers should display on top of each other.


    const beaches = <?php echo $lokasi ?>;

    function setMarkers(map) {
        // Adds markers to the map.
        // Marker sizes are expressed as a Size of X,Y where the origin of the image
        // (0,0) is located in the top left of the image.
        // Origins, anchor positions and coordinates of the marker increase in the X
        // direction to the right and in the Y direction down.

        const image = {
            url: "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png",
            url: "{{url('assets/img_logo/tracking3.png')}}",
            // url : "https://img.icons8.com/color/28/000000/pointer.png",
            // This marker is 20 pixels wide by 32 pixels high.
            size: new google.maps.Size(30, 35),
            // The origin for this image is (0, 0).
            origin: new google.maps.Point(0, 0),
            // The anchor for this image is the base of the flagpole at (0, 32).
            anchor: new google.maps.Point(0, 32),
        };
        // Shapes define the clickable region of the icon. The type defines an HTML
        // <area> element 'poly' which traces out a polygon as a series of X,Y points.
        // The final coordinate closes the poly by connecting to the first coordinate.
        const shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: "poly",
        };

        // for (let i = 0; i < beaches.length; i++) {
        //     const beach = beaches[i];

        //     new google.maps.Marker({
        //     position: { lat: beach[i].lat_tujuan, lng: beach[i].long_tujuan },
        //     map,
        //     icon: image,
        //     shape: shape,
        //     title: beach[i].nama_driver,
        //     zIndex: beach[3],
        //     });
        // }

        // Create an info window to share between markers.
        // const infoWindow = new google.maps.InfoWindow();

        for (i = 0; i < beaches.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(beaches[i].lat_sekarang, beaches[i].long_sekarang),
                map: map,
                icon: image,
                title: beaches[i].nama_driver
            });

            // marker.addListener("click", () => {
            // infoWindow.close();
            // infoWindow.setContent(marker.getTitle());
            // infoWindow.open(marker.getMap(), marker);
            // });


            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                const contentString =
                '<div id="content">' +
                '<div id="siteNotice">' +
                "</div>" +
                '<h5 id="firstHeading" class="firstHeading">'+beaches[i].nama_driver+'</h5>' +
                    '<div id="bodyContent">' +
                        '<h5 class="mb-3">Info</h5>'+
                        '<table class="table fs-8 fw-bold gs-0 gy-2 gx-2">' +
                            '<tr class="">'+
                                '<td class="text-gray-400">Pemesan:</td>'+
                                '<td class="text-gray-800">'+beaches[i].petugas+'</td>'+
                            '</tr>'+
                            '<tr class="">'+
                                '<td class="text-gray-400">Tujuan:</td>'+
                                '<td class="text-gray-800">'+beaches[i].tujuan+'</td>'+
                            '</tr>'+
                        '</table>'
                    "</div>" +
                "</div>";
                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 200,
                });
                return function() {
                    // infoWindow.close();
                    // infoWindow.setContent(marker.getTitle());
                    // infoWindow.open(marker.getMap(), marker);
                    infowindow.open({
                    anchor: marker,
                    map,
                    // shouldFocus: false,
                    });
                }
            })(marker, i));
        }
    }

</script>
@endpush
