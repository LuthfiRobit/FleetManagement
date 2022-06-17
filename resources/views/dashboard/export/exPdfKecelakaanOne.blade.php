<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Kecelakaan</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
    <!--begin::Global Stylesheets Bundle(used by all pages)-->

    {{--
    <link href="{{ asset('assets/backend/assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" /> --}}
    <!--end::Global Stylesheets Bundle-->
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 300px; height: 100px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>Laporan Kecelakaan</h1>
    </header>
    <main>
        <div id="notices" style="margin-bottom: 10px">
            <div>DETAIL:</div>
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>No. Kecelakaan</td>
                    <td>No. DO</td>
                    <td>Tgl. Kecelakaan</td>
                    <td>Jam Kecelakaan</td>
                </tr>
                <tr>
                    <td>ACD_{{$kecelakaan->id_kecelakaan}}</td>
                    <td>DO_{{$kecelakaan->no_so}}</td>
                    <td>{{Carbon\Carbon::parse($kecelakaan->tgl)->format('d-m-Y')}}</td>
                    <td>{{Carbon\Carbon::parse($kecelakaan->jam)->format('H:i')}}</td>
                </tr>
                <tr>
                    <td>Driver</td>
                    <td>Saksi</td>
                    <td>Lokasi Kecelakaan</td>
                    <td>Tujuan Perjalanan</td>
                </tr>
                <tr>
                    <td>{{$kecelakaan->nama_driver}}</td>
                    <td>{{$kecelakaan->saksi}}</td>
                    <td>{{$kecelakaan->lokasi}}</td>
                    <td>{{$kecelakaan->tujuan}}</td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>KENDARAAN:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NAMA KENDARAAN :</td>
                    <td>{{$kecelakaan->kendaraan}}</td>
                    <td>NO. ASSET :</td>
                    <td>{{$kecelakaan->kode_asset}}</td>
                    <td>NO. POLISI :</td>
                    <td>{{$kecelakaan->no_polisi}}</td>
                    <td>TIPE :</td>
                    <td>{{$kecelakaan->jenis}}</td>
                </tr>
                <tr>
                    <td>WARNA :</td>
                    <td>{{$kecelakaan->warna}}</td>
                    <td>MERK :</td>
                    <td>{{$kecelakaan->merk}}</td>
                    <td>PENGGERAK :</td>
                    <td>{{$kecelakaan->jenis_penggerak}}</td>
                    <td>BAHAN BAKAR</td>
                    <td>{{$kecelakaan->bahan_bakar}}</td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>KRONOLOGI:</div>
            <div class="notice">{{$kecelakaan->kronologi}}</div>
        </div>
    </main>
</body>

</html>
