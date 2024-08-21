@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <script src="{{asset('admin/sweetalert2.js')}}" type="text/javascript"></script>
        <script>
            $('document').ready(function () {
                setTimeout(function() {
                    swal({
                        title: '{!! $message['message'] !!}',
                        text: '{!! $message['message'] !!}',
                        type: '{{ $message['level'] }}',
                        timer: 3000,
                        showConfirmButton: false
                    })
                }, {{isset($MESSDELAY)?$MESSDELAY:1}});
            });
        </script>
    @endif
@endforeach
{{ session()->forget('flash_notification') }}
