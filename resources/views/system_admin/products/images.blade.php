<?php
$images=[];
foreach ($out->images as $a){
$images[]=$a->image;
?>
<div class="edit_images">
    <img src="<?=asset('uploads/'.$a->image)?>" class="Muti-Image-prev" alt="">
    <div class="actions">


            <a href="#" class="DelImage" data-url="{{route('system.products.delete_image')}}" data-image="<?=$a->id?>" title="حذف" style="color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                <i class="fa fa-trash "></i>
            </a>


    </div>
</div>
<?php
}
?>
<input type="hidden" value='<?= json_encode($images) ?>'  class="uploaded_multi_image_name" name="uploaded_multi_image_name">
