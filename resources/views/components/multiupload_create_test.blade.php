<div class="row multimg_container" style="border-radius: unset!important;">
    <div class="text" style="border-radius: unset!important;text-align: unset;">
        <div style="width: 50%;float: right;margin-top:20px;text-align: center;">
            <h3 style="font-weight:bold;"> {{$text}} </h3>
            <h5>الرجاء سحب الصورة في المكان المحدد</h5>
        </div>
        <div style="width: 50%;float: left;border-right: #000 2px solid;">
            <small style="margin-bottom: 5px;font-weight: bold;font-size: 13px;text-align: right;padding: 5px;">أبعاد الصورة المصغرة : {{isset($thumbwidth) && isset($thumbheight)? " صورة $thumbname "."بمقاس $thumbwidth : $thumbheight ":'400 * 400'.' بيكسل'}}</small>
            <small style="margin-bottom: 5px;font-weight: bold;font-size: 13px;text-align: right;padding: 5px;">أبعاد الصورة الرئيسة : {{isset($mainwidth) && isset($mainheight)?  " صورة $mainname "."بمقاس $mainwidth : $mainheight ":'400 * 400'.' بيكسل'}}</small>
            <small style="margin-bottom: 5px;font-weight: bold;font-size: 13px;text-align: right;padding: 5px;">أبعاد صورة السلايدر : {{isset($sliderwidth) && isset($sliderheight)?  " صورة $slidername "."بمقاس $sliderwidth : $sliderheight ":'400 * 400'.' بيكسل'}}</small>
            <small style="margin-bottom: 5px;font-weight: bold;font-size: 13px;text-align: right;padding: 5px;">أبعاد صورة الاشعار : {{isset($notificationwidth) && isset($notificationheight)?  " صورة $notificationname "."بمقاس $notificationwidth : $notificationheight ":'400 * 400'.' بيكسل'}}</small>
        </div>
    </div>
    <div class="col-md-12">
        <input type="file" id="MYimage_{{$name}}" style="display: none" multiple name="file"
               class="upload_image_multi1">
        <input type="hidden" value='<?= old($name, '[]') ?>'
               class="uploaded_multi_image_name"
               name="{{$name}}">
        <input type="hidden" value='<?= old('widths', '[]') ?>'
               class="uploaded_multi_image_width"
               name="widths">
        <input type="hidden" value='<?= old('heights', '[]') ?>'
               class="uploaded_multi_image_height"
               name="heights">
        <div class="MultiImagePrev" id="MultiImagePrev" style="border-radius: unset!important;padding: 10px;overflow:hidden;">
            <label for="MYimage_{{$name}}" class="MutiImageText" style="text-align:center;padding: 0;width: 115px;height: 150px;border-radius: unset!important;">
                <div style="margin-top: 35px">اختر صور لرفعها</div>
                <i class="fa fa-image fa-2x MutiImageTextIcon" style="float: unset;margin-top: auto;margin-right: auto;margin-left: unset;"></i>
            </label>
            <div class="MultiImagePrevImages" id="MultiImagePrevImages" style="display: inline-block;width: 80%;float: left;">
                <?php
                if (old($name)) {
                $arr = json_decode(old($name));
                foreach ($arr as $a) {
                ?>
                <div class="square edit_images"  data-width="{{HELPER::getImageWidth($a)}}" data-height="{{HELPER::getImageHeight($a)}}" data-name="{{$a}}" style="background-image: url('{{asset('uploads/'.$a)}}');background-size:contain;background-position:center;background-repeat: no-repeat;width: 115px;height: 150px;">
                    <div class="actions">
                        <a href="#" class="DelImageCreate" data-image="<?=$a?>" title="حذف"
                           style="color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                            <i class="fa fa-trash "></i>
                        </a>
                        <a href="#" class="DelImageChoosed" data-image="<?=$a?>" title="حذف"
                           style="display:none;color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                            <i class="fa fa-trash "></i>
                        </a>
                    </div>
                </div>
                <?php
                }
                }
                ?>
            </div>

            <div class="row" style="width: 100%;height: 180px;text-align: center;border-top:1px solid #bcbcbc;margin-left:unset;margin-right:unset;">
               <div style="margin: auto">
                   <div style="display: inline-block;">
                       <h6 style="text-align: center">الصورة المصغرة</h6>
                       <div id="dropThump" style="width: 115px;height: 150px;" data-width="{{isset($thumbwidth)?$thumbwidth:400}}" data-height="{{isset($thumbheight)?$thumbheight:400}}" class="squaredotted">

                       </div>
                       <input required type="hidden" id="thumpimage" name="thumpimage" value="">
                   </div>
                   <div style="display: inline-block;">
                       <h6 style="text-align: center">الصورة الرئيسة</h6>
                       <div  id="dropDef" style="width: 115px;height: 150px;" data-width="{{isset($mainwidth)?$mainwidth:400}}" data-height="{{isset($mainheight)?$mainheight:400}}" class="squaredotted">

                       </div>
                       <input required type="hidden" id="defimage" name="defimage" value="">
                   </div>
                   <div id="slider_image" style="display: inline-block;">
                       <h6 style="text-align: center">صورة السلايدر</h6>
                       <div id="dropSlider" style="width: 115px;height: 150px;" data-width="{{isset($sliderwidth)?$sliderwidth:400}}" data-height="{{isset($sliderheight)?$sliderheight:400}}" class="squaredotted">

                       </div>
                       <input required type="hidden" id="sliderimage" name="sliderimage" value="">
                   </div>
                   <div id="notification_image" style="display: inline-block;">
                       <h6 style="text-align: center">صورة الاشعار</h6>
                       <div id="dropNot" style="width: 115px;height: 150px;" data-width="{{isset($notificationwidth)?$notificationwidth:400}}" data-height="{{isset($notificationheight)?$notificationheight:400}}" class="squaredotted">

                       </div>
                       <input required type="hidden" id="notimage" name="notimage" value="">
                   </div>
               </div>
            </div>

        </div>
        @show_error($name)
        @show_error('thumpimage')
        @show_error('defimage')

    </div>

</div>


