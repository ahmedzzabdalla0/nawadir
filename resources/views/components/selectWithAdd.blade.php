<div class="form-group m-form__group @has_error('{{$name}}')">    <label for="{{$name}}">{{$text}} </label>    <select name="{{$name}}" search="true" id="{{$name}}" {{isset($not_req)?'':'required'}} data-addurl="{{$add_url}}" data-token="{{csrf_token()}}" >        @if(!isset($no_def))        <option value="0">{{isset($placeholder)?$placeholder:$text}}</option>        @endif            <option value="9911Add_NeW_tO_The_LiST9911" > اضافة عنصر جديد</option>        @foreach($select as $s)            <option value="{{$s->id}}" {{old($name,isset($data)?$data:null)==$s->id?'selected':''}}>{{$s->name}}</option>        @endforeach    </select>    @show_error($name)</div>