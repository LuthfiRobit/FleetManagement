<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Laporan Perbaikan Tgl.
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d, F Y') }}
            </td>
        </tr>
        <tr>
            <th>No. Wo</th>
            <th>Dealer</th>
            <th>Kendaraan</th>
            <th>Tgl. Mulai</th>
            <th>Tgl. Penyelesaian</th>
            @if ($status == 's')
            <th>Tgl. Selesai</th>
            @endif
            <th>Status Penyelesaian</th>
            @if ($status == 's')
            <th>Total Biaya</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($perbaikan as $pb)
        <tr>
            <td>WO_{{ $pb->no_wo }}</td>
            <td>{{$pb->nama_dealer}}</td>
            <td>{{$pb->nama_kendaraan}}|{{$pb->no_polisi}}</td>
            <td> {{\Carbon\Carbon::parse($pb->tgl_perbaikan)->format('d-m-Y')}}</td>
            <td> {{\Carbon\Carbon::parse($pb->tgl_selesai)->format('d-m-Y')}}</td>
            @if ($status == 's')
            <td> {{\Carbon\Carbon::parse($pb->tgl_selesai_pengerjaan)->format('d-m-Y')}}</td>
            @endif
            <td>
                @if ($status == 's')
                Selesai (
                @if($pb->status_penyelesaian == 'o')
                <span class="badge badge-light-primary">ON TIME</span>
                @elseif($pb->status_penyelesaian == 'p')
                <span class="badge badge-light-danger">PENALTI</span>
                @endif
                )
                @else
                PROSES (
                @if (\Carbon\Carbon::parse($pb->tgl_selesai)->lessThanOrEqualTo(\Carbon\Carbon::parse($tanggal)))
                PENALTI
                @else
                ON GOING
                @endif
                )
                @endif
            </td>
            @if ($status == 's')
            <td>{{$pb->biaya}}</td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
