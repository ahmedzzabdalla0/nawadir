<div class="row multimg_container">
        <div class="text">
            <h5> {{$text}} </h5>
            <small>{{isset($hint)?$hint:'400 * 400 بيكسل'}}</small>
        </div>
    <div class="col-md-10">
                <label for="MYimage_{{$name}}" class="MutiImageText" style="width: 100%;">
                    <span>اختر صور لرفعها</span>
                    <i class="fa fa-image fa-2x MutiImageTextIcon"></i>
                </label>
        <input type="file" id="MYimage_{{$name}}" style="display: none" multiple name="file" data-url="{{route($add_route)}}" data-place="<?=$out->id?>" class="upload_image_multi2">

                <input type="file" id="MYimage_{{$name}}" style="display: none" multiple name="file"
                       class="upload_image_multi">
                <div class="MultiImagePrev">
                    @include($path)

                </div>
        @show_error($name)

    </div>
    <div class="col-md-2">
        <div class="imageContainer">
            <img src="<?= $defimage ? asset('uploads/' . $defimage) : url('blank.png') ?>"
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
