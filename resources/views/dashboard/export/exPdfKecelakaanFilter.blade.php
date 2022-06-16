<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Kecelakaan</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 300px; height: 100px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>Laporan Kecelakaan Bulan {{ \Carbon\Carbon::parse($filter['bulan'])->translatedFormat('m, Y') }} 
        </h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                     <th>No</th>
                    <th>No. Kecelakaan</th>
                    <th>No. DO</th>
                    <th>Kendaraan</th>
                    <th>Tanggal | Jam</th>
                    <th>Lokasi Kecelakaan</th>
                </tr>
                @foreach ($kecelakaan as $kc)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>ACD_{{$kc->id_kecelakaan}}</td>
                    <td>DO_{{$kc->no_so}}</td>
                    <td>
                        {{$kc->kendaraan}}
                        <br>
                        <span class="badge badge-light-primary">{{$kc->no_polisi}}</span>
                    </td>
                    <td>
                        @if ($kc->tgl != null )
                        {{Carbon\Carbon::parse($kc->tgl)->format('d-m-y') }}
                        @else
                        ---
                        @endif
                        |
                        @if ($kc->jam != null)
                        {{Carbon\Carbon::parse($kc->jam)->format('H:i') }}
                        @else
                        ---
                        @endif
                    </td>
                    <td>
                        @if ($kc->lokasi != null)
                        {{$kc->lokasi}}
                        @else
                        ---
                        @endif

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
