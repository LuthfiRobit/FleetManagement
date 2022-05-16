<div>
    @foreach ($biaya_penugasan as $item)

    @if ($item['acc_oleh']== null)
    ok
    @else
    {{$item['acc_oleh']}}
    @endif
    @endforeach
</div>
