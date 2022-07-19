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
        <h1>History Pengecekan Driver | 
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
                    <td>Jumlah Pengecekan</td>
                </tr>
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
    </main>
</body>

</html>
