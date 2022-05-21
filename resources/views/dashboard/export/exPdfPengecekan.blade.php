<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Pengecekan</title>
    {{--
    <link rel="stylesheet" href="{{ asset('assets/css/styleInvoice.css')}}" media="all" /> --}}
    <style type="text/css">
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5d6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 100%;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 5px 0;
            margin-bottom: 5px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        h1 {
            border-top: 1px solid #5d6975;
            border-bottom: 1px solid #5d6975;
            color: #5d6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            /* background: url(dimension.png); */
        }

        #project {
            float: left;
            margin-right: 250px;
        }

        #company span,
        #project span {
            color: #5d6975;
            text-align: left;
            width: 52px;
            margin-right: 20px;
            display: inline-block;
            font-size: 0.8em;
        }

        /* #company {
  float: right;
} */

        #company div {
            white-space: initial;
        }

        #project div {
            white-space: nowrap;
        }

        table {
            width: fit-content;
            /* border-collapse: collapse; */
            border-spacing: 0;
            margin-bottom: 20px;
            border-style: dashed;
            border-radius: 10px;
            border-color: #c1ced9;
        }

        .right {
            position: relative;
            margin-left: 250px;
        }

        table tr:nth-child(2n-1) td {
            background: #f5f5f5;
        }

        table th,
        table td {
            text-align: left;
        }

        table td .right {
            text-align: center;
        }

        table th {
            padding: 5px 20px;
            color: #5d6975;
            border-bottom: 1px solid #c1ced9;
            white-space: nowrap;
            font-weight: normal;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding-left: 20px;
            text-align: left;
        }

        table td.service,
        table td.desc,
        s table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
            vertical-align: top;
        }

        table td.grand {
            border-top: 1px solid #5d6975;
        }

        #notices .notice {
            color: #5d6975;
            font-size: 1.2em;
        }

        footer {
            color: #5d6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #c1ced9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img style="width: 300px; height: 100px; margin-right: 20px"
                src="{{ public_path('assets/img_logo/logo_pomi1.png')}}">
        </div>
        <h1>Laporan Pengecekan Kendaraan</h1>
    </header>
    <main>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>TANGGAL :</td>
                    <td> {{Carbon\Carbon::parse($pengecekan->tgl_pengecekan)->format('d F
                        Y')}}</td>
                    <td>JAM :</td>
                    <td>{{Carbon\Carbon::parse($pengecekan->jam_pengecekan)->format('H:i')}}</td>
                    <td>NAMA DRIVER :</td>
                    <td>{{$pengecekan->nama_driver}}</td>
                </tr>
                <tr>
                    <td>MOBIL :</td>
                    <td> {{$pengecekan->nama_kendaraan}}</td>
                    <td>NO. POLISI :</td>
                    <td>{{$pengecekan->no_polisi}}</td>
                    <td>NOMOR MOBIL :</td>
                    <td>{{$pengecekan->kode_asset}}</td>
                </tr>
                <tr>
                    <td>TAHUN PEMBUATAN :</td>
                    <td> {{$pengecekan->tahun_kendaraan}}</td>
                    <td>MEREK :</td>
                    <td>{{$pengecekan->merk}}</td>
                    <td>WARNA :</td>
                    <td>{{$pengecekan->warna}}</td>
                </tr>
                <tr>
                    <td>TIPE :</td>
                    <td>{{$pengecekan->jenis}}</td>
                    <td>PENGGERAK :</td>
                    <td>{{$pengecekan->jenis_penggerak}}</td>
                    <td>KM/PENGECEKAN :</td>
                    <td>{{$pengecekan->km_kendaraan}} Km</td>
                </tr>
            </tbody>
        </table>
        <table border="none">
            <!--begin::Table body-->
            <tbody class="fs-6 fw-bold text-gray-600">
                @foreach ($detail_check as $de)
                <tr>
                    <td colspan="3" align="center"><strong>{{$de['nama_kriteria']}}</strong></td>
                <tr class="text-start text-muted text-uppercase gs-0">
                    <th>Tipe</th>
                    <th>Kondisi</th>
                    <th class="min-w-125px">Keterangan</th>
                </tr>
                @forelse ($de['list_jenis'] as $dp)
                <tr>
                    {{-- <td>{{$dp->kriteria}}</td> --}}
                    <td>{{$dp['jenis']}}</td>
                    <td>
                        @if($dp['kondisi'] == 'b')
                        <span class="badge badge-light-success">Baik/Normal</span>
                        @else
                        <span class="badge badge-light-danger">Rusak/Tidak Normal</span>
                        @endif
                    </td>
                    <td>
                        @if ($dp['keterangan'] != null)
                        {{$dp['keterangan']}}
                        @else
                        ----
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" align="center">Belum ada pengecekan</td>
                </tr>
                @endforelse
                </td>
                </tr>
                @endforeach
            </tbody>
            <!--end::Table body-->
        </table>
        <div id="notices">
            <div>INSPECTOR:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
    </main>
    {{-- <footer>
        Copyright &copy; <b><a href="http://bcpasuruan.com/" class="text-black">bcpasuruan.com</a><br>
    </footer> --}}
</body>

</html>
