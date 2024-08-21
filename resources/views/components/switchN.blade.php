<div class="row justify-content-between">
    <label class="fs-14" for="{{$name}}">{{$text}} </label>
    <div  style="text-align: left;">
            <span class="m-switch m-switch--icon">
                <label>
                    {{--<input type="checkbox" value="1" {{old($name,isset($data)?$data:null)==1?'checked="checked"':''}}>--}}
                    <input autocomplete="false" type="checkbox" id="{{$name}}"  name="{{$name}}" data-toggle="toggle" value="1" {{old($name,isset($data)?$data:null)==1?'checked="checked"':''}} >
                    <span></span>
                </label>
            </span>
    </div>
    <div class="col-12" style="text-align: center">
        @show_error($name)
    </div>
</div>
