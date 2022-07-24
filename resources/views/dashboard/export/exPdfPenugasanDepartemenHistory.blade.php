<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Penugasan Departemen</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 200px; height: 75px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>History Perjalanan Departemen | 
            @if ($filter['bulan'] != '')
                Bulan {{ \Carbon\Carbon::parse($filter['bulan'])->translatedFormat('m, Y') }}
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
                    <th>Departemen</th>
                    <th>Jumlah Total Perjalanan</th>
                    <th>Jumlah Perjalanan Lokal</th>
                    <th>Jumlah Perjalanan Out Of Town</th>
                </tr>
                 @foreach ($history as $h)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$h->nama_departemen}}</td>
                    <td>{{$h->jumlah_total}}</td>
                    <td>{{$h->jumlah_lokal}}</td>
                    <td>{{$h->jumlah_out}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
