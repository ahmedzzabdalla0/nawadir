<?php
$images=[];
foreach ($out->images as $a){
$images[]=$a->image;
?>
<div class="edit_images">
    <img src="<?=url('uploads/'.$a->image)?>" class="Muti-Image-prev" alt="">
    <div class="actions">

        <?php
        if($a->is_main ==1){
        ?>
        <i class="fa fa-star"
           style="color: green;cursor: pointer;font-size: 1.2em" title="الصورة الرئيسية"></i>
        <?php
        }else{
        ?>
            <a href="#" class="SetAsDefault" data-url="{{route('system.activities.default_image')}}" data-image="<?=$a->id?>" title="تعيين كصورة رئيسية" style="color: yellow;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                <i class="fa fa-star "></i>
            </a>
            <a href="#" class="DelImage" data-url="{{route('system.activities.delete_image')}}" data-image="<?=$a->id?>" title="حذف" style="color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                <i class="fa fa-trash "></i>
            </a>
        <?php
        }
        ?>


    </div>
</div>
<?php
}
?>
<input type="hidden" value='<?= json_encode($images) ?>'  class="uploaded_multi_image_name" name="uploaded_multi_image_name">
