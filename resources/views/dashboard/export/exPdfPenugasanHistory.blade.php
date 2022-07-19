<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Penugasan</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="widtd: 300px; height: 100px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>History Penugasan Driver | 
            @if ($filter['status'] == 'b')
                Bulan {{ \Carbon\Carbon::parse($filter['bulan'])->translatedFormat('m, Y') }}
            @elseif ($filter['status']== 'h')
                Dari Tanggal {{ \Carbon\Carbon::parse($filter['tgl_awal'])->translatedFormat('d-m-Y') }} - 
                Tanggal {{ \Carbon\Carbon::parse($filter['tgl_akhir'])->translatedFormat('d-m-Y') }}
            @else
            Semua
            @endif
        </h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>No</td>
                    <td>Nama Driver</td>
                    <td>No. Tlp</td>
                    <td>Jumlah Penugasan</td>
                    <td>Penugasan Baru</td>
                    <td>Penugasan Diterima</td>
                    <td>Penugasan Perjalanan</td>
                    <td>Penugasan Selesai</td>
                    <td>Penugasan Batal</td>
                </tr>
                 @foreach ($history as $h)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$h['nama_driver']}}</td>
                    <td>{{$h['no_tlp']}}</td>
                    <td>{{$h['history']['jumlah_all']}}</td>
                    <td>{{$h['history']['jumlah_menunggu']}}</td>
                    <td>{{$h['history']['jumlah_terima']}}</td>
                    <td>{{$h['history']['jumlah_perjalan']}}</td>
                    <td>{{$h['history']['jumlah_selesai']}}</td>
                    <td>{{$h['history']['jumlah_batal']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
