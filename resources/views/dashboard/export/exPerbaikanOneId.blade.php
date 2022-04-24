<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No. Wo</th>
            <th>Dealer</th>
            <th>Kendaraan</th>
            <th>Tgl. Mulai</th>
            <th>Tgl. Penyelesaian</th>
            <th>Tgl. Selesai</th>
            <th>Status Penyelesaian</th>
            <th>Total Biaya</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>WO_{{ $perbaikan->no_wo }}</td>
            <td>{{$perbaikan->nama_dealer}}</td>
            <td>{{$perbaikan->nama_kendaraan}}|{{$perbaikan->no_polisi}}</td>
            <td> {{\Carbon\Carbon::parse($perbaikan->tgl_perbaikan)->format('d-m-Y')}}</td>
            <td> {{\Carbon\Carbon::parse($perbaikan->tgl_selesai)->format('d-m-Y')}}</td>
            <td> {{\Carbon\Carbon::parse($perbaikan->tgl_selesai_pengerjaan)->format('d-m-Y')}}</td>
            <td>
                @if($perbaikan->status_penyelesaian == 'o')
                <span class="badge badge-light-primary">ON TIME</span>
                @elseif($perbaikan->status_penyelesaian == 'p')
                <span class="badge badge-light-danger">PENALTI</span>
                @endif
            </td>
            <td>Rp.
                {{$perbaikan->total}}</td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Detail Komponen</td>
        </tr>
        <tr>
            <th>Komponen</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($komponen as $kom)
        <tr>
            <td>{{ $kom->nama_komponen }}</td>
            <td>{{$kom->jml_komponen}}</td>
            <td>Rp. {{$kom->harga_satuan}}</td>
            <td>Rp. {{$kom->jml_komponen * $kom->harga_satuan}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
