<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Departemen</th>
            <th>Jumlah Total Perjalanan</th>
            <th>Jumlah Perjalanan Lokal</th>
            <th>Jumlah Perjalanan Out Of Town</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($history as $h)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$h->nama_departemen}}</td>
                <td>
                @if ($h->jumlah_total != 0)
                    {{$h->jumlah_total}}
                @else
                    0
                @endif
                </td>
                <td>
                    @if ($h->jumlah_lokal != 0)
                        {{$h->jumlah_lokal}}
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if ($h->jumlah_out != 0)
                        {{$h->jumlah_out}}
                    @else
                        0
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
