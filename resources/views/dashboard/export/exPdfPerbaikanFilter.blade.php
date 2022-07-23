<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Perbaikan</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/styleInvoice.css')}}" media="all" />
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 200px; height: 75px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>Laporan Perbaikan Bulan {{ \Carbon\Carbon::parse($filter['bulan'])->translatedFormat('m, Y') }} | Status 
            @if ($filter['status'] == 'p')
            <span class="badge badge-light-primary">Proses</span>
            @elseif($filter['status'] == 's')
            <span class="badge badge-light-danger">Selesai</span>
            @else
            ---
            @endif
        </h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                 <tr >
                    <td>No.</td>
                    <td>No. WO</td>
                    <td>Dealer</td>
                    <td>Kendaraan</td>
                    <td>Tgl. Mulai</td>
                    <td>Tgl. Penyelesaian</td>
                    <td>Tgl. Selesai</td>
                    <td>Status Perbaikan</td>
                    <td>Status Penyelesaian</td>
                </tr>
                @foreach ($perbaikan as $pr)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>WO_{{$pr->no_wo}}</td>
                    <td>{{$pr->nama_dealer}}</td>
                    <td>
                        {{$pr->nama_kendaraan}} | 
                        {{-- <br> --}}
                        <span class="badge badge-light-primary">{{$pr->no_polisi}}</span>
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($pr->tgl_perbaikan)->format('d, M Y')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($pr->tgl_selesai)->format('d, M Y')}}
                    </td>
                    <td>
                        @if ($pr->tgl_penyelesaian != null)
                        {{\Carbon\Carbon::parse($pr->tgl_penyelesaian)->format('d, M Y')}}
                        @else
                        ---
                        @endif
                    </td>
                    <td>
                        @if($pr->status_perbaikan == 's')
                        <span class="badge badge-light-primary">SELESAI</span>
                        @else
                        <span class="badge badge-light-warning">PROSES</span>
                        @endif
                    </td>
                    <td>
                        @if($pr->status_penyelesaian == 'o')
                        <span class="badge badge-light-primary">ON TIME</span>
                        @elseif($pr->status_penyelesaian == 'p')
                        <span class="badge badge-light-danger">PENALTI</span>
                        @else
                        <span class="badge badge-light-warning">BELUM</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
