<tr id="TR_<?= $a->id ?>">
    <td class="LOOPIDS order_new">1</td>
    <td class="text-center">
        <a href="{{route('system.orders.details',$a->id)}}" target="_blank"> <?= $a->id ?></a>
    </td>
    <td class="text-center">
        <?= $a->name ?>
    </td>
    <td class="text-center">
        {{@$a->user->name}}
    </td>
    <td class="text-center">
        {{@$a->driver?$a->driver->name:'-'}}
    </td>

    <td class="text-center"><?= $a->total_price ?> {{HELPER::set_if($config['currency'])}}</td>
    <td class="text-center">
        {{$a->products()->count()}}
    </td>

    <td class="text-center" id="STAT_<?= $a->id ?>">
        <span style="color: {{@$a->status->color_hex}}">{{@$a->status->name}}</span>
    </td>
    <td class="text-center">
        <ul class="list-inline">
            <li>
                <a href="{{route('system.orders.details',$a->id)}}"
                   class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                   data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"
                >
                    <i class="fa fa-desktop"></i> عرض </a>
            </li>
            @if($a->case_id < 3)
                <li>
                    <button type="button"
                            data-id="{{$a->id}}"
                            data-url="{{route('system.orders.delete')}}"
                            data-token="{{csrf_token()}}"
                            data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                            class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                        <i class="fa fa-trash "></i>
                        حذف
                    </button>


                </li>
            @endif

        </ul>
    </td>
</tr>
