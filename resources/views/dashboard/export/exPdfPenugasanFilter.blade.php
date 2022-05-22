<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Penugasan</title>
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
        <h1>Laporan Penugasan Driver {{$bulan}}</h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NO.</td>
                    <td>NO. DO</td>
                    <td>DRIVER</td>
                    <td>PEMESAN</td>
                    <td>KENDARAAN</td>
                    <td>TANGGAL | JAM</td>
                    <td>STATUS</td>
                </tr>
                @foreach ($assignment as $as)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>DO_{{$as->no_so}}</td>
                    <td>{{$as->nama_driver}}</td>
                    <td>{{$as->nama_petugas}}</td>
                    <td>{{$as->nama_kendaraan}} | <span class="badge badge-light-primary">{{$as->no_polisi}}</span>
                    </td>
                    <td>
                        {{Carbon\Carbon::parse($as->tgl_penugasan)->format('d F Y') }} |
                        {{Carbon\Carbon::parse($as->jam_berangkat)->format('H:i') }}
                    </td>
                    <td>
                        @if ($as->status_do == 't')
                        <span class="badge badge-light-primary">Diterima</span>
                        @elseif($as->status_do == 'p')
                        <span class="badge badge-light-danger">Process</span>
                        @elseif($as->status_do == 's')
                        <span class="badge badge-light-success">Selesai</span>
                        @elseif($as->status_do == 'c')
                        <span class="badge badge-light-success">Batal</span>
                        @else
                        <span class="badge badge-light-warning">Baru</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
