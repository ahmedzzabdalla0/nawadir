<div class="form-group m-form__group @has_error($name)">    <label for="{{$name}}">{{$text}} </label>    <select name="{{$name}}" search="true" id="{{$name}}" {{isset($not_req)?'':'required'}}>        @if(!isset($no_def))        <option value="">{{isset($placeholder)?$placeholder:$text}}</option>        @endif        @foreach($select as $s)            <option value="{{$s->id}}" {{old($name,isset($data)?$data:null)==$s->id?'selected':''}}>{{$s->name}}</option>        @endforeach    </select>    @show_error($name)</div>