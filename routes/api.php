<?php

use Illuminate\Http\Request;



//===============================================================

//                 User ROUTES

//===============================================================


Route::prefix('user/')->namespace('API\User')->group(function () {

    // without Auth
    Route::post('sendOtp', 'AuthController@sendOtp');

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('forget_password', 'AuthController@forgetPassword');
    Route::post('activate_mobile', 'AuthController@apiValidateMobile');
    Route::post('resend_code', 'AuthController@ResendCode');
    Route::post('update_device_key', 'AuthController@updateDeviceKey');
    Route::post('add_remove_cart', 'ProductController@add_remove_cart');

    // with Auth
    Route::middleware(['APIauth'])->group(function () {
        Route::post('update_profile', 'AuthController@apiUpdate');
        
                Route::post('delete_profile', 'AuthController@delete_profile');

        
        Route::post('change_password', 'AuthController@changePassword');
        Route::post('seen_notification', 'AuthController@setUserNotificationToSeen');
        Route::post('delete_notification', 'AuthController@DeleteUserNotification');
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::get('get_user_address', 'OrderController@getAddress');
        Route::get('getDriverLastLocation', 'OrderController@getDriverLastLocation');


//        -------
        Route::post('add_order', 'OrderController@apiAddOrder');
                Route::post('update_status', 'OrderController@update_status');

        Route::post('cancel_order', 'OrderController@apiCancelOrder');
        Route::post('delete_notification', 'AuthController@DeleteUserNotification');
        Route::post('add_remove_fav', 'ProductController@add_remove_fav');
        Route::post('add_remove_cart', 'ProductController@add_remove_cart');
        Route::post('delete_cart', 'ProductController@delete_cart');

        Route::post('add_to_wallet', 'AuthController@addToWallet');

    });

    Route::get('wallet_details', 'AuthController@wallet_details');
    Route::get('get_user_notifications', 'AuthController@getUserNotifications');


    Route::post('contact_us', 'GeneralController@contactUs');

    Route::post('add_user_address', 'OrderController@addUserAddress');
    Route::post('delete_user_address', 'OrderController@deleteUserAddress');

    Route::post('edit_user_address', 'OrderController@updateUserAddress');

    Route::get('get_orders', 'OrderController@getUserOrders');


    Route::get('get_about_page', 'GeneralController@getAboutPage');
    Route::get('get_rules_page', 'GeneralController@getRulesPage');
    Route::get('get_polices_page', 'GeneralController@getPolicesPage');
    Route::get('get_configuration', 'GeneralController@config');
    Route::get('get_categories', 'GeneralController@cats');
    Route::get('get_areas', 'GeneralController@getAreas');
    Route::get('get_cut_types_images', 'GeneralController@get_cut_types_images');
    Route::get('get_categories_with_products', 'GeneralController@cats_with_products');
    Route::get('ads', 'GeneralController@ads');


    Route::post('forgetPassword', 'GeneralController@forgetPassword');

    Route::get('get_home', 'ProductController@getHome');
    Route::get('get_products', 'ProductController@getProducts');
    Route::get('get_user_favorite', 'ProductController@getUserFav');
    Route::get('get_product_details', 'ProductController@getProductDetails');
    Route::get('get_order_details', 'OrderController@order_details');
    Route::get('get_user_cart', 'ProductController@getUserCart');

});


Route::prefix('driver/')->namespace('API\Driver')->group(function () {

    // without Auth

    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('forget_password', 'AuthController@forgetPassword');
    Route::post('activate_mobile', 'AuthController@apiValidateMobile');
    Route::post('resend_code', 'AuthController@ResendCode');
    Route::post('update_device_key', 'AuthController@updateDeviceKey');
                    Route::post('delete_profile', 'AuthController@delete_profile');

    // with Auth
    Route::middleware(['APIauth:driver'])->group(function () {
                Route::get('user', 'AuthController@driver');

        Route::post('update_profile', 'AuthController@apiUpdate');
        Route::post('change_password', 'AuthController@changePassword');
        Route::post('seen_notification', 'AuthController@setUserNotificationToSeen');
        Route::post('delete_notification', 'AuthController@DeleteUserNotification');
        Route::post('logout', 'AuthController@logout');

        Route::get('get_driver_notifications', 'AuthController@getUserNotifications');


        Route::get('get_orders', 'OrderController@getUserOrders');
        Route::get('get_archived_orders', 'OrderController@getUserArchivedOrders');
        Route::get('get_order_details', 'OrderController@order_details');


//        -------
        Route::post('change_order_status', 'OrderController@ChangeOrderStatus');
        Route::post('UpdateDriverLocation', 'OrderController@UpdateDriverLocation');

    });

});




Route::any('MADA', "HyperPayController@index")->name('MADA');

Route::any('knet_succsess', "KnetController@success")->name('knet.success');

Route::any('knet_fail', "KnetController@fail")->name('knet.fail');

Route::any('succsess', "KnetController@successdone")->name('knet.success.done');

Route::any('CronJobs', "API\User\GeneralController@cronJobs");
