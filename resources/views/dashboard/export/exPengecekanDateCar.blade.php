<table class="table table-bordered" border="1">
    <thead>
        <tr>
            <td colspan="7" class="text-center">Laporan Pengecekan Tgl.
                {{ \Carbon\Carbon::parse($checkCar[0]['tgl_pengecekan'])->translatedFormat('d, F Y') }}
            </td>
        </tr>
        <tr>
            <th>Nama Kendaraan</th>
            <th>Kode Asset</th>
            <th>No Polisi</th>
            <th>Merk</th>
            <th>Jenis</th>
            <th>Penggerak</th>
            <th>Bahan Bakar</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $checkCar[0]['nama_kendaraan'] }}</td>
            <td>{{$checkCar[0]['kode_asset']}}</td>
            <td>{{ $checkCar[0]['no_polisi'] }}</td>
            <td>{{$checkCar[0]['merk']}}</td>
            <td>{{$checkCar[0]['jenis']}}</td>
            <td>{{$checkCar[0]['jenis_penggerak']}}</td>
            <td>{{$checkCar[0]['bahan_bakar']}}</td>
        </tr>
    </tbody>
</table>
@foreach ($checkCar as $cc)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Detail Pengecekan</th>
            <th>Oleh : {{$cc['nama_driver']}}</th>
            <th>Jam : {{$cc['jam_pengecekan']}}</th>
            <th>Status Kendaraan : {{$cc['status_kendaraan']}}</th>
            <th>Status Pengecekan : {{$cc['status_pengecekan']}}</th>
            <th>KM/Pengecekan : {{$cc['km_kendaraan']}}</th>
        </tr>
        <tr>
            <th class="min-w-100px">Kriteria</th>
            <th>Tipe</th>
            <th>Kondisi</th>
            <th class="min-w-125px">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        {{-- <tr>
            {{$cc->list_detail}}
        </tr> --}}
        @foreach ($cc['list_detail'] as $dp)
        <tr>
            <td>{{$dp['kriteria']}}</td>
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
        @endforeach
    </tbody>
</table>
@endforeach
