<table class="table table-bordered">
    <thead>
        <tr>
            <td>No. Kecelakaan</td>
            <td>No. Do</td>
            <td>Driver</td>
            <td>Kendaraan</td>
            <td>No. Polisi</td>
            <td>Tgl. Jam. Kecelakaan</td>
            <td>Atasan</td>
            <td>Saksi</td>
            <td>Lokasi</td>
            <td>Tujuan</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($acdn as $acd)
        <tr>
            <td>ACD_{{ $acd->id_kecelakaan }}</td>
            <td>DO_{{$acd->id_do}}</td>
            <td>{{ $acd->nama_driver }}</td>
            <td>{{$acd->kendaraan}}</td>
            <td>{{$acd->no_polisi}}</td>
            <td>{{Carbon\Carbon::parse($acd->tgl)->format('d-m-Y')}} |
                {{Carbon\Carbon::parse($acd->jam)->format('H:i')}}</td>
            <td>{{ $acd->atasan }}</td>
            <td>{{$acd->saksi}}</td>
            <td>{{ $acd->lokasi }}</td>
            <td>{{$acd->tujuan}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
