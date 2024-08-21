<?php
$images=[];
foreach ($out->all_images()->get() as $a){
$images[]=$a->image;
?>
<div class="square edit_images" data-width="{{HELPER::getImageWidth($a->image)}}" data-height="{{HELPER::getImageHeight($a->image)}}" data-name="{{$a->image}}" style="background-image: url('{{asset('uploads/'.$a->image)}}');background-size:contain;background-position:center;background-repeat: no-repeat;width: 115px;height: 150px;">
    <div class="actions">


            <a href="#" class="DelImage1 DelImageUpdate" data-url="{{route('system.products.delete_image1')}}" data-image="<?=$a->id?>" title="حذف" style="color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                <i class="fa fa-trash "></i>
            </a>
            <a href="#" class="DelImageChoosed"  title="ازالة"
                style="display: none;color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">

                                <i class="fa fa-trash "></i>

            </a>


    </div>
</div>
<?php
}
?>
<input type="hidden" value='<?= json_encode($images) ?>'  class="uploaded_multi_image_name" name="uploaded_multi_image_name">
