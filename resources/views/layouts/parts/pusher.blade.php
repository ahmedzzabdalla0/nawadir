<span id="IS_GRANTED_NOTIFY" style="display: none;visibility: hidden">0</span>
<audio id="PlAyAuDiO" src="{{asset('admin/notify.mp3')}}" autostart="false" ></audio>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>

<script>
    // Check permissions
    if ("Notification" in window) {
        var permission = Notification.permission;
        console.log(permission);
        if (permission === "granted") {
            granted();
        } else {
            denied();
        }

        Notification.requestPermission().then(function () {
        });
    } else {
        denied();
    }


    function granted() {
        $('#IS_GRANTED_NOTIFY').text('1');
//            displayNotification('سيتم تبليغك بالطلبات الجديدة بهذه الطريقة','./style/admin/cheak.png','تعريف');

    }

    function denied() {
        $('#IS_GRANTED_NOTIFY').text('0');
//            displayNotification('سيتم تبليغك بالطلبات الجديدة بهذه الطريقة','fa fa-ban','تعريف');

    }

    function displayNotification(body, icon, title, link, duration) {
        link = link || 0; // Link is optional
        duration = duration || 5000; // Default duration is 5 seconds

        var is_granted = $('#IS_GRANTED_NOTIFY').text();
        var sound = document.getElementById("PlAyAuDiO");
        sound.play();
        if (is_granted == '1'||is_granted == 1) {
            var options = {
                body: body,
                icon: icon
            };

            var n = new Notification(title, options);

            if (link) {
                n.onclick = function () {
                    window.open(link);
                };
            }

            setTimeout(n.close.bind(n), duration);

        } else {


            swal({
                title: title,
                text: body,
                type: 'info',
                timer: 3000,
                showConfirmButton: false
            });

        }

    }



    var pusher = new Pusher('{{$config['pusher_auth_key']}}', {
        cluster: 'ap2',
        forceTLS: true
    });

    var channel = pusher.subscribe('alqasim_orders');
    channel.bind('add_order', function (data) {
        updateNotificationsCount();
        updateNewOrdersCount();
        displayNotification(data.text, '{{url('admin/bell.png')}}','طلب جديد','{{route('system.orders.index')}}/details/'+data.order_id);
        addRow(data);
    });

    channel.bind('change_order', function (data) {
        updateNotificationsCount();
        displayNotification(data.text, '{{url('admin/bell.png')}}','تحديث على طلب','{{route('system.orders.index')}}/details/'+data.order_id);
        addRow(data);

    });


    function addRow(data){
        var OrderList = $('#OrderList').length;
        var id = data.order_id;
        var ORstatus = data.order_status;


        if (OrderList > 0) {
            if(ORstatus >=5){
                if($('#Order_'+id).length >0){
                    $('#Order_'+id).remove();
                }

                $.get("{{route('system.orders.new_row')}}",
                    {
                        id: id,
                    },
                    function (data, status) {
                        if (data.done == 1) {
                            $("#OrderList").prepend(data.out);
                            $(".order_old").each(function () {
                                var old = parseInt($(this).text());
                                old = old + 1;
                                $(this).text(old);
                            });

                            $('.order_new').removeClass('order_new').addClass('order_old');


                        } else {
                        }
                    });
            }

        }else{
            var listNew=$('#OrderListStatus_'+ORstatus).length;
            if(ORstatus == 5){
                $('#Order_'+id).remove();
            }
            if (listNew > 0 && ORstatus != 5) {
                $('#Order_'+id).remove();
                $.get("{{route('system.orders.new_row_2')}}",
                    {
                        id: id,
                    },
                    function (data, status) {
                        if (data.done == 1) {
                            $('#OrderListStatus_'+ORstatus).prepend(data.out);

                        } else {
                        }
                    });
            }

        }
    }
    function updateNewOrdersCount(){
        if($('#new_orders_counter').length >= 1){
            var num =parseInt($('#new_orders_counter').html());
            $('#new_orders_counter').empty().html(num+1);
        }
    }




    $('#NotificationBill').click(function (e) {

        updateNotifications();
    });


    function updateNotificationsCount() {
        jQuery.ajax({

            url:"{{route('system_admin.get.notifications')}}",

            type: 'GET',

            data: {
                'only_count':1
            },


            beforeSend: function (XMLHttpRequest) {

                $('body').removeClass("loading");


            },

            success: function (data) {
                if (data.done == 1) {

                    $('#NotificationCount').html(data.count);
                    $('#NotificationItems').html(data.items);
                }
            }
        });


    }
    function updateNotifications() {
        $('#NotificationItems').parents('.m-dropdown__body').addClass('loading');

        jQuery.ajax({

            url:"{{route('system_admin.get.notifications')}}",

            type: 'GET',

            data: {

            },


            beforeSend: function (XMLHttpRequest) {

                $('body').removeClass("loading");


            },

            success: function (data) {
                if (data.done == 1) {

                    $('#NotificationCount').html(data.count);
                    $('#NotificationItems').html(data.items).parents('.m-dropdown__body').removeClass('loading');
                }
            }
        });


    }
</script>
