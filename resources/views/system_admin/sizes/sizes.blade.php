@if(isset($sizes) && count($sizes) > 0)

    @foreach($sizes as $size)
        <div class="col-md-6 row" style="height: 30px!important;">
            <div class="col-md-4">
     <span class="m-switch m-switch--icon m-switch--sm">
                                                        <label>
                                                            <input type="checkbox" id="size_{{$size->id}}" data-name="{{$size->name}}" class="size-choose" name="size_choose"
                                                                   value="{{$size->id}}" >
                                                            <span></span>
                                                        </label>
                                                    </span>
            </div>
            <div class="col-md-8" style="font-weight: bold;padding-top: 8px;">
                {{$size->name}}
            </div>
        </div>
    @endforeach

@else
    <div class="note note-info">
        <h4 class="block">لا يوجد بيانات للعرض</h4>
    </div>
@endif
