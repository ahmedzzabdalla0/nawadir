<div class="row">    <h3 class="col-5 " for="{{$name}}">{{$text}} </h3>    <div class="col-5" style="text-align: right;">            <span class="m-switch m-switch--icon">                <label>                    {{--<input type="checkbox" value="1" {{old($name,isset($data)?$data:null)==1?'checked="checked"':''}}>--}}                    <input type="checkbox" id="{{$name}}"  name="{{$name}}" data-toggle="toggle" value="1" {{old($name,isset($data)?$data:null)==1?'checked="checked"':''}} >                    <span></span>                </label>            </span>    </div>    <div class="col-12" style="text-align: center">        @show_error($name)    </div></div>