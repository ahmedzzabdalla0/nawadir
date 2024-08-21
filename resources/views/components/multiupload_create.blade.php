<div class="row multimg_container">
    <div class="text">
        <h5> {{$text}} </h5>
        <small>{{isset($hint)?$hint:'400 * 400 بيكسل'}}</small>
    </div>
    <div class="col-md-10">
        <label for="MYimage_{{$name}}" class="MutiImageText">
            <span>اختر صور لرفعها</span>
            <i class="fa fa-image fa-2x MutiImageTextIcon"></i>
        </label>
        <button class="btn MainImageSelect" data-toggle="modal"
                data-target="#imageModal" type="button" data-inputname="{{$name}}">
            الصورة الرئيسية<i class="fa fa-check" id="ChickIfImageSelected2" style="display: none"></i>
        </button>

        <input type="file" id="MYimage_{{$name}}" style="display: none" multiple name="file"
               class="upload_image_multi">

        <input type="hidden" value="<?= old($name1) ?>" name="{{$name1}}"
               class="uploaded_image_def">

        <input type="hidden" value='<?= old($name, '[]') ?>'
               class="uploaded_multi_image_name"
               name="{{$name}}">
        <div class="MultiImagePrev">
            <?php
            if (old($name)) {
            $arr = json_decode(old($name));
            foreach ($arr as $a) {
            ?>
            <div class="edit_images">

                <img src="<?= asset('uploads/' . $a) ?>" class="Muti-Image-prev" alt="">
                <div class="actions">
                    <a href="#" class="DelImageCreate" data-image="<?=$a?>" title="حذف"
                       style="color: red;cursor: pointer;font-size: 1.2em;text-decoration: none;">
                        <i class="fa fa-trash "></i>
                    </a>
                </div>
            </div>
            <?php
            }
            }
            ?>

        </div>
        @show_error($name)

    </div>
    <div class="col-md-2">
        <div class="imageContainer">
            <img src="<?= old($name1) ? url('uploads/' . old($name1)) : url('blank.png') ?>"
                 class="img-fluid thumbnail" id="DefaultImagePrev" alt="">
            <div class="image-loader"></div>
        </div>
    </div>
</div>
<div id="imageModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="imagePrev"></div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" style="display: none" class="btn btn-default" id="CloSEForm" data-dismiss="modal">
                    اغلاق
                </button>
            </div>
        </div>

    </div>
</div>

