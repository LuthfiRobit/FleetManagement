<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Pengecekan</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 300px; height: 100px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>Laporan Pengecekan Bulan {{ \Carbon\Carbon::parse($filter['bulan'])->translatedFormat('m, Y') }} | Status 
                        @if ($filter['status'] == 'r')
                        <span class="badge badge-light-primary">Tersedia</span>
                        @elseif($filter['status'] == 't')
                        <span class="badge badge-light-danger">Tidak Tersedia</span>
                        @else
                        ---
                        @endif
        </h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>No.</td>
                    {{-- <td>No. Pengecekan</td> --}}
                    <td>Tanggal</td>
                    <td>Oleh</td>
                    <td>Kendaraan</td>
                    <td>Kilometer</td>
                    <td>Status</td>
                    <td>Pengecekan</td>
                </tr>
                 @foreach ($pengecekan as $pc)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    {{-- <td>VC_{{$pc->id_pengecekan}}</td> --}}
                    <td>{{ \Carbon\Carbon::parse($pc->tgl_pengecekan)->translatedFormat('d-m-Y') }}
                    </td>
                    <td>{{$pc->nama_driver}}</td>
                    <td>
                        <span class="badge badge-light-warning">{{$pc->no_polisi}}</span> | 
                        {{$pc->nama_kendaraan}}
                    </td>
                    <td>{{$pc->km_kendaraan}}</td>
                    <td>
                        @if ($pc->status_kendaraan == 'r')
                        <span class="badge badge-light-primary">Normal</span>
                        @else
                        <span class="badge badge-light-danger">Rusak</span>
                        @endif
                    </td>
                    <td>
                        @if($pc->status_pengecekan == 'c')
                        <span class="badge badge-light-primary">Harian</span>
                        @else
                        <span class="badge badge-light-danger">Kecelakaan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
