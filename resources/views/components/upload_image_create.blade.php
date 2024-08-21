<h7 style="color: gray;text-align: right;display: block;">{{isset($hint)?$hint:'400 * 400 px'}}</h7>

<div class="imageContainer" style="margin-top: 15px;">
    <div style="text-align: center;">
        <label for="MYimage_{{$name}}" style="width: 150px;cursor: pointer;">
            <img src="<?= old($name,isset($data)?$data:null) ? url('uploads/' . old($name,isset($data)?$data:null)) : url('avatar.png') ?>"
                 style="width: 150px;" class="MyImagePrivew thumbnail"
                 alt="">
        </label>
        <input type="file" id="MYimage_{{$name}}" style="display: none"
               name="file"
               class="upload_image">
        <input type="hidden" value="<?= old($name,isset($data)?$data:null) ?>"
               name="{{$name}}" class="uploaded_image_name">
        <div class="image-loader"></div>
    </div>

</div>
@show_error($name)
