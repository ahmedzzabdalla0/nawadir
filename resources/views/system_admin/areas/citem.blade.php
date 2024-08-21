<div class="productItem_country">
    @cando('delete','areas')
    <?php if ($a->areas()->count() == 0) { ?>
    <button class="btn-del-without delaps del_country"
            data-id="<?= $a->id ?>"
            data-aaa="tooltip"
            data-url="{{route('system.areas.delete_country')}}"
            data-token="<?= csrf_token() ?>"
            title="حذف"><i class="fa fa-trash"></i>
    </button>
    <?php } ?>
    @endcando
    @cando('edit','areas')
    <button class="editaps edit_country" data-aaa="tooltip"
            data-id="<?= $a->id ?>"
            data-name="<?= $a->name ?>"
            data-name_en="<?= $a->name_en ?>"
            title="تعديل">
        <i class="fa fa-edit"></i>
    </button>
    @endcando
    <div class="titleww">
        <p><?= $a->name ?> - <?= $a->name_en ?></p>

    </div>

    <div class="areas">
        <?php
        foreach ($a->areas as $b) { ?>

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

        <?php } ?>


        <button type="button" title="اضافة مدينة جديدة" data-aaa="tooltip"
                class="productItem2 AddNewCity" data-country="<?= $a->id ?>">

            <i class="fas fa-plus"></i>
        </button>


        <div class="clearfix"></div>
    </div>
</div>

