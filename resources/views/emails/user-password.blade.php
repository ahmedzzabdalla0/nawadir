
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img width="100" height="100" src="{{asset('admin/imgs/logo_w.png') }}" alt="{{ config('app.name') }} Logo">
            <h4>{{ config('app.name') }}</h4>
        @endcomponent
    @endslot

    Your New password is:
    <h4>{{$code}}</h4>
    Thanks,
    {{ config('app.name') }}


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
