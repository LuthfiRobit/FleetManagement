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
        <h1>Laporan Perbaikan</h1>
    </header>
    <main>
        <div id="notices" style="margin-bottom: 10px">
            <div>DETAIL:</div>
        </div>
        <table border="none">
            <tbody>
                 <tr>
                    <td>No. Wo</td>
                    <td>Dealer</td>
                    <td>Kendaraan</td>
                    <td>Total Biaya</td>
                    
                </tr>
                <tr>
                    <td>WO_{{ $perbaikan->no_wo }}</td>
                    <td>{{$perbaikan->nama_dealer}}</td>
                    <td>{{$perbaikan->nama_kendaraan}}|{{$perbaikan->no_polisi}}</td>
                    <td>Rp.
                        {{$perbaikan->total}}</td>
                    
                </tr>
                <tr>
                    <td>Tgl. Mulai</td>
                    <td>Tgl. Penyelesaian</td>
                    <td>Tgl. Selesai</td>
                    <td>Status Penyelesaian</td>
                </tr>
                <tr>
                    <td> {{\Carbon\Carbon::parse($perbaikan->tgl_perbaikan)->format('d-m-Y')}}</td>
                    <td> {{\Carbon\Carbon::parse($perbaikan->tgl_selesai)->format('d-m-Y')}}</td>
                    <td> {{\Carbon\Carbon::parse($perbaikan->tgl_penyelesaian)->format('d-m-Y')}}</td>
                    <td>
                        @if($perbaikan->status_penyelesaian == 'o')
                        <span class="badge badge-light-primary">ON TIME</span>
                        @elseif($perbaikan->status_penyelesaian == 'p')
                        <span class="badge badge-light-danger">PENALTI</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>KOMPONEN:</div>
        </div>
        <table border="none">
             <tr>
                <td>Komponen</td>
                <td>Jumlah</td>
                <td>Harga</td>
                <td>Total</td>
            </tr>
            @foreach($detail_perbaikan as $kom)
            <tr>
                <td>{{ $kom->nama_komponen }}</td>
                <td>{{$kom->jml_komponen}}</td>
                <td>Rp. {{$kom->harga_satuan}}</td>
                <td>Rp. {{$kom->jml_komponen * $kom->harga_satuan}}</td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>
