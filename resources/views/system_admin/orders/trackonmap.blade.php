@extends('layouts.admin')

@php
    $Disname='الطلبات';
@endphp
@section('title',  $Disname)

@section('head')
    <link href="{{asset('metronic/global/plugins/bootstrap-select/css/bootstrap-select-rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic/pages/css/profile-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('page_content')
    <div class="m-subheader hide-prnt">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{url('/')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system_admin.dashboard')}}" class="m-nav__link">
                            <span class="m-nav__link-text">لوحة التحكم</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system.orders.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">#{{$out->id}}</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>



    <div class="m-content">
        <div class="row">
            <div class="col-xl-12">
                <div id="map" style="min-height: 700px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script>
        var map;
        function myMap() {
            var mapProp= {
                center:new google.maps.LatLng({{$user_lat}}, {{$user_lng}}),
                zoom:12,
            };
            map  = new google.maps.Map(document.getElementById("map"),mapProp);
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{HELPER::set_if($config['map_geolocation_key'])}}&callback=myMap" ></script>

    <script>
           var infowindow = new google.maps.InfoWindow();

            var family_point = {lat: {{$user_lat}}, lng: {{$user_lng}}};
            // carCoordinates[points] = family_point;
            // points++;
            var family_marker = new google.maps.Marker({
                position: family_point,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
                },
                 title: '{{$out->user->name}}',
                map: map
            });
                google.maps.event.addListener(family_marker, 'mouseover', function() {
                    infowindow.setContent('<div style="text-align:center;width: 120px;">{{$out->user->name}}</div>'+'<br>'+'<div style="text-align:center;">{{$out->user->mobile}}</div>');
                    infowindow.open(map, family_marker);
                });
    </script>
@endsection

