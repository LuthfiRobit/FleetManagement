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
            <img style="width: 200px; height: 75px; margin-right: 20px"
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
