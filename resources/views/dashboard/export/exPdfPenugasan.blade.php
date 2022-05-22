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
        <h1>Laporan Penugasan Driver</h1>
    </header>
    <main>
        <div id="notices" style="margin-bottom: 10px">
            <div>PENUGASAN:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NO. DO :</td>
                    <td>DO_{{$detail->no_so}}</td>
                    <td>PEMESAN :</td>
                    <td>{{$detail->nama_petugas}}</td>
                    <td>NO. TLP :</td>
                    <td>{{$detail->p_tlp}}</td>

                </tr>
                <tr>
                    <td>TGL. PENJEMPUTAN :</td>
                    <td>{{Carbon\Carbon::parse($detail->tgl_penugasan)->format('d F Y')}}</td>
                    <td>JAM PENJEMPUTAN :</td>
                    <td>{{Carbon\Carbon::parse($detail->jam_berangkat)->format('H:i')}}</td>
                    <td>STATUS :</td>
                    <td>
                        @if ($detail->status_do == 't')
                        <div class="badge badge-lg badge-light-primary d-inline">
                            Diterima
                        </div>
                        @elseif($detail->status_do == 'p')
                        <div class="badge badge-lg badge-light-warning d-inline">
                            Process
                        </div>
                        @elseif($detail->status_do == 's')
                        <div class="badge badge-lg badge-light-success d-inline">
                            Selesai
                        </div>
                        @elseif($detail->status_do == 'c')
                        <div class="badge badge-lg badge-light-danger d-inline">
                            Dibatalkan
                        </div>
                        @else
                        <div class="badge badge-lg badge-light-warning d-inline">
                            Menunggu Konfirmasi
                        </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>TEMPAT TUJUAN :</td>
                    <td>{{$detail->tujuan}}</td>
                    <td>TEMPAT PENJEMPUTAN :</td>
                    <td>{{$detail->tempat_penjemputan}}</td>
                    <td>TEMPAT KEMBALI :</td>
                    <td>{{$detail->kembali}}</td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>DRIVER:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NAMA :</td>
                    <td>{{$driver->nama_driver}}</td>
                    <td>DEPARTEMEN :</td>
                    <td>{{$driver->departemen}}</td>
                    <td>NO. TLP :</td>
                    <td>{{$driver->d_tlp}}</td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>KENDARAAN:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NAMA KENDARAAN :</td>
                    <td>{{$detail->nama_kendaraan}}</td>
                    <td>NO. ASSET :</td>
                    <td>{{$detail->kode_asset}}</td>
                    <td>NO. POLISI :</td>
                    <td>{{$detail->no_polisi}}</td>
                    <td>TIPE :</td>
                    <td>{{$detail->jenis}}</td>
                </tr>
                <tr>
                    <td>WARNA :</td>
                    <td>{{$detail->warna}}</td>
                    <td>MERK :</td>
                    <td>{{$detail->merk}}</td>
                    <td>PENGGERAK :</td>
                    <td>{{$detail->jenis_penggerak}}</td>
                    <td>BAHAN BAKAR</td>
                    <td>{{$detail->bahan_bakar}}</td>
                </tr>
            </tbody>
        </table>
        <div id="notices" style="margin-bottom: 10px">
            <div>PENUMPANG:</div>
            {{-- <div class="notice">Formulir ini dibuat berdasarkan data yang sudah didaftarkan.</div> --}}
        </div>
        <table border="none">
            <tbody class="fs-6 fw-bold text-gray-600">
                <tr>
                    <td>NAMA PENUMPANG</td>
                    <td>JABATAN</td>
                    <td>NO. TLP</td>
                </tr>
                @foreach ($penumpang as $pn)
                <tr>
                    <td>
                        <label class="w-150px">{{$pn->nama_penumpang}}</label>
                    </td>
                    <td>{{$pn->nama_jabatan}}</td>
                    <td>
                        <span class="badge badge-light-danger">{{$pn->no_tlp}}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
