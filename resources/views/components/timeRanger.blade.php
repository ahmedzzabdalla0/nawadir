<div class="form-group m-form__group  @has_error($name)">
    <label for="{{$name}}">{{$text}} </label>
    <div class="input-group input-timeRange">
        <input class="form-control m-input m-input--pill" id="m_timepicker_1"name="{{$name}}_from" value="@old($name.'_from',isset($data_from)?$data_from:null)" readonly placeholder="بوقت " type="text" />
        <button type="button" class="reset_field"><i class="fa fa-times"></i></button>
        <input class="form-control m-input m-input--pill" id="m_timepicker_2"name="{{$name}}_to"  value="@old($name.'_to',isset($data_to)?$data_to:null)" readonly placeholder="حتى" type="text" />
    </div>
</div>