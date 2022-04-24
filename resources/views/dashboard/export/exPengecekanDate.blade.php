@foreach ($checkCar as $cc)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Oleh : {{$cc['nama_driver']}}</th>
            <th>Tanggal : {{$cc['tgl_pengecekan']}}</th>
            <th>Jam : {{$cc['jam_pengecekan']}}</th>
            <th>Nama Kendaraan : {{$cc['nama_kendaraan']}}</th>

        </tr>
        <tr>
            <th>Kode Asset : {{$cc['kode_asset']}}</th>
            <th>No Polisi : {{$cc['no_polisi']}}</th>
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
