<div class="productItem">
    @cando('delete','areas')
    <?php if ($b->can_del) { ?>
    <button class="btn-del-without delaps"
            data-id="<?= $b->id ?>"
            data-aaa="tooltip"
            data-url="{{route('system.areas.delete_city')}}"
            data-token="<?= csrf_token() ?>"
            title="حذف"><i class="fa fa-trash"></i>
    </button>
    <?php } ?>
    @endcando
    @cando('edit','areas')
    <button class="editaps edit_city" data-aaa="tooltip"
            data-id="<?= $b->id ?>"
            data-name="<?= $b->name ?>"
            data-name_en="<?= $b->name_en ?>"
            title="تعديل">
        <i class="fa fa-edit"></i>
    </button>
    @endcando
    <p><?= $b->name ?> - <?= $b->name_en ?></p>
</div>