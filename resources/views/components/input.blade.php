<div class="form-group m-form__group @has_error($name)"  style="{{HELPER::endWith($name, '_en') !== false?'direction:ltr;text-align: left;':''}}" {{HELPER::endWith($name, '_en') !== false?'dir="ltr"':''}}>
    <label for="{{$name}}">{{$text}}<span id="{{$name.'_related'}}" style="display: none;"></span></label>
    <div class="m-input-icon m-input-icon--{{HELPER::endWith($name, '_en') !== false?'right':'left'}}">
        <input @if(isset($type))
               @if($type == 'date')
               data-provide="datepicker"
               type="text"
               @if(isset($startDate))
               data-date-start-date="{{$startDate}}"
               @else
               data-date-start-date="{{\Carbon\Carbon::now()->subYears(10)->toDateString()}}"
               @endif
               @else
               type="{{$type}}"
               @endif
               @if($type == "password")
               autocomplete="off"
               @endif
               @else
               type="text"

               @endif class="form-control m-input m-input--pill m-input--air" placeholder="{{isset($placeholder)?$placeholder:$text}}"
               {{isset($not_req)?'':'required'}} {{isset($min)?'min:'.$min:''}} name="{{$name}}" value="@old($name,isset($data)?$data:null)" id="{{$name}}">
        <span class="m-input-icon__icon m-input-icon__icon--{{HELPER::endWith($name, '_en') !== false?'right':'left'}}"><span><i class="{{isset($icon_pre)?$icon_pre:'fa'}} {{isset($icon)?$icon:'fa-desktop'}}"></i></span></span>
    </div>
    @show_error($name)

</div>
