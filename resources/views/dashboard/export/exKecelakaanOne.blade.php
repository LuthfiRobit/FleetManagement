<table class="table table-bordered">
    <tbody>
        <tr>
            <td>Tgl. Kecelakaan</td>
            <td>No. Kecelakaan</td>
            <td>No. Do</td>
            <td>Driver</td>
            <td>Kendaraan</td>
            <td>No. Polisi</td>
        </tr>
        <tr>
            <td>{{Carbon\Carbon::parse($acd->tgl)->format('d-m-Y')}}</td>
            <td>ACD_{{ $acd->id_kecelakaan }}</td>
            <td>ACD_{{$acd->id_do}}</td>
            <td>{{ $acd->nama_driver }}</td>
            <td>{{$acd->kendaraan}}</td>
            <td>{{$acd->no_polisi}}</td>
        </tr>
        <tr>
            <td>Jam. Kecelakaan</td>
            <td>Atasan</td>
            <td>Saksi</td>
            <td>Lokasi</td>
            <td>Tujuan</td>
            <td>Kronologi</td>
        </tr>
        <tr>
            <td> {{Carbon\Carbon::parse($acd->jam)->format('H:i')}}</td>
            <td>{{ $acd->atasan }}</td>
            <td>{{$acd->saksi}}</td>
            <td>{{ $acd->lokasi }}</td>
            <td>{{$acd->tujuan}}</td>
            <td>{{$acd->kronologi}}</td>
        </tr>
    </tbody>
</table>
