<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Laporan Pengecekan Tgl.
                {{ \Carbon\Carbon::parse($checkCar->tgl_pengecekan)->translatedFormat('d, F Y') }}
            </td>
            <td>Oleh
                {{$checkCar->nama_driver}}
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
            <th>Km/Pengecekan</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach($users as $user) --}}
        <tr>
            <td>{{ $checkCar->nama_kendaraan }}</td>
            <td>{{$checkCar->kode_asset}}</td>
            <td>{{ $checkCar->no_polisi }}</td>
            <td>{{$checkCar->merk}}</td>
            <td>{{$checkCar->jenis}}</td>
            <td>{{$checkCar->jenis_penggerak}}</td>
            <td>{{$checkCar->bahan_bakar}}</td>
            <td>{{$checkCar->km_kendaraan}} Km</td>
        </tr>
        {{-- @endforeach --}}
    </tbody>
</table>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="4">Detail Pengecekan</th>
        </tr>
        <tr>
            <th class="min-w-100px">Kriteria</th>
            <th>Tipe</th>
            <th>Kondisi</th>
            <th class="min-w-125px">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail as $dp)
        <tr>
            <td>{{$dp->kriteria}}</td>
            <td>{{$dp->jenis}}</td>
            <td>
                @if($dp->kondisi == 'b')
                <span class="badge badge-light-success">Baik/Normal</span>
                @else
                <span class="badge badge-light-danger">Rusak/Tidak Normal</span>
                @endif
            </td>
            <td>
                @if ($dp->keterangan != null)
                {{$dp->keterangan}}
                @else
                ----
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
