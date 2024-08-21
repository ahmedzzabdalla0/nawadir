<div class="form-group m-form__group @has_error($name)">
    <label for="{{$name}}">{{$text}} </label>
    <select name="{{$name}}" search="true" style="padding: 5px 15px!important;" id="{{$name}}" {{isset($not_req)?'':'required'}} class="form-control m-input m-input--pill m-input--air no_nice_select">
        @if(!isset($no_def))
        <option value="">{{isset($placeholder)?$placeholder:$text}}</option>
        @endif
        @foreach($select as $s)
            <option value="{{$s->id}}" {{old($name,isset($data)?$data:null)==$s->id?'selected':''}}>{{$s->name}}</option>
        @endforeach
    </select>

    @show_error($name)

</div>
