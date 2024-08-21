<div class="form-group">

    <div class="col-md-12">
        <label class="control-label">{{$text}}</label>
        <style type="text/css">
            #MYmap {
                width: 100% !important;
                height: 300px !important;
                border: 2px solid #ebedf2;
                border-radius: 25px;
                box-shadow: 0px 3px 20px 0px rgba(113,106,202,0.11);

            }
        </style>
        <input type="hidden" id="{{isset($name1)?$name1:'lat'}}" name="{{isset($name1)?$name1:'lat'}}" value="@old($name1,isset($data1)?$data1:29.372764)">
        <input type="hidden" id="{{isset($name2)?$name2:'lng'}}" name="{{isset($name2)?$name2:'lng'}}" value="@old($name2,isset($data2)?$data2:47.975358)">

        <div id="MYmap"></div>
    </div>

</div>
{{--29.372764, 47.975358--}}
<script src="https://maps.googleapis.com/maps/api/js?key={{HELPER::set_if($config['map_geolocation_key'])}}"></script>
<script src="{{asset('admin/gmaps.js')}}" type="text/javascript"></script>
<script>
    var map = new GMaps({
        el: '#MYmap',
        lat: @old($name1,isset($data1)?$data1:{{\App\Http\Controllers\ControllersService::getDefaultCountry()->def_lat}}),
        lng: @old($name2,isset($data2)?$data2:{{\App\Http\Controllers\ControllersService::getDefaultCountry()->def_lng}}),
    });

    marker=map.createMarker({
        lat: @old($name1,isset($data1)?$data1:{{\App\Http\Controllers\ControllersService::getDefaultCountry()->def_lat}}),
        lng: @old($name2,isset($data2)?$data2:{{\App\Http\Controllers\ControllersService::getDefaultCountry()->def_lng}}),
        title: '{{$text}}',
        draggable:true,
        dragend: function(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            $('#{{isset($name1)?$name1:'lat'}}').val(lat);
            $('#{{isset($name2)?$name2:'lng'}}').val(lng);

        },
    });
    map.addMarker(marker);



</script>
