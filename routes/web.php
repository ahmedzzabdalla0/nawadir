<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ProductVariant;
use App\Models\Settings;
use App\Models\Variant;
use App\Helpers\UUID;
use App\Models\CaseGeneral;


Route::get('user/password/reset/{token}', 'Password\UserPasswordController@showResetForm')->name('user.password.reset-form');
Route::post('user/password/reset', 'Password\UserPasswordController@reset')->name('user.password.reset');


Route::get('/', 'WebsiteController@gotoIndex')->name('website.home2');
Route::get('home', 'WebsiteController@index')->name('website.home');
Route::get('error419', 'WebsiteController@error419')->name('website.error419');
Route::post('/contact_us', 'WebsiteController@contactUs')->name('website.do.contact');

Route::get('/page/{id}', 'WebsiteController@show_page')->name('website.page');
Route::get('activate_als', 'WebsiteController@do_activate')->middleware('guest')->name('web.activate');
Route::get('blocked', 'WebsiteController@blocked')->middleware('guest')->name('web.blocked');
Route::get('activate', 'WebsiteController@do_activate')->middleware('guest')->name('website.activate');
Route::post('do/activate', 'WebsiteController@doactivate')->middleware('guest')->name('website.do.activate');
Route::get('/activity/{name}/{id}', 'WebsiteController@show_activity')->name('website.activity');
Route::post('/addActivity', 'WebsiteController@do_activity')->name('website.do.activity');





//Route::middleware(['SecuredHttp'])->group(function () {

    //===============================================================
//                 SYSTEM ADMIN ROUTES
//===============================================================
    Route::prefix('admin/system')->group(function () {
        Route::get('/login', 'Auth\SystemAdminLoginController@showLoginForm')->middleware(['guest:system_admin'])->name('system_admin.showLogin');
        Route::post('/login', 'Auth\SystemAdminLoginController@login')->middleware(['guest:system_admin'])->name('system_admin.login');
        Route::get('/logout', 'Auth\SystemAdminLoginController@logout')->middleware(['auth:system_admin', 'active','delete_temp'])->name('system_admin.logout');
    });

    Route::prefix('admin/system')->middleware(['auth:system_admin'])->group(function () {
        Route::view('/activation', 'system_admin.system_activation')->name('system_admin.activation');
        Route::post('/activate', 'SystemAdminController@activate')->name('system_admin.activate');
    });


    Route::prefix('admin/system')->middleware(['auth:system_admin','LogoutAdminSession'])->group(function () {
        Route::get('/', 'SystemAdminController@home')->name('system_admin.dashboard');
        Route::get('/generalProperties', 'SystemAdminController@generalProperties')->name('system_admin.generalProperties');


        Route::prefix('settings')->middleware(['checkRule:view,settings'])->group(function (){
            Route::get('/{type?}','SettingController@index')->name('system.settings.index');
            Route::post('add','SettingController@add')->name('system.settings.add');
            Route::post('create-bank', "BankController@create")->name('system.banks.do.create');
            Route::post('update-bank', 'BankController@update')->name('system.banks.do.update');
            Route::post('delete-bank', 'BankController@delete')->name('system.banks.delete');
        });

        Route::get('getNotifications', 'SettingController@getNotifications')->name('system_admin.get.notifications');



//=====================================================================================================
//                   ADMIN ROUTRS
//=====================================================================================================

        Route::prefix('admins/')->middleware(['checkRule:view,admin'])->group(function () {
            Route::get('', 'AdminsController@index')->name('system.admin.index');
            Route::get('show_create', "AdminsController@showCreateView")->name('system.admin.create');
            Route::post('create', "AdminsController@create")->name('system.admin.do.create');
            Route::get('show_change_permission/{id}', "AdminsController@showPermissionView")->name('system.admin.permission');
            Route::post('change_permission', "AdminsController@changePermission")->name('system.admin.do.permission');
            Route::get('{id}/update', 'AdminsController@showUpdateView')->name('system.admin.update');
            Route::post('update/{id}', 'AdminsController@Update')->name('system.admin.do.update');
            Route::get('{id}/password', 'AdminsController@showPasswordView')->name('system.admin.password');
            Route::post('password/{id}', 'AdminsController@password')->name('system.admin.do.password');
            Route::post('delete', 'AdminsController@delete')->name('system.admin.delete');
        });
        Route::prefix('profile')->group(function (){
            Route::get('','AdminsController@showProfileView')->name('system.admin.profile');
            Route::get('showpassword','AdminsController@showProfilePasswordView')->name('system.admin.profile.password');
            Route::post('updatepassword', 'AdminsController@profilePassword')->name('system.admin.do.profile.password');

            Route::post('do_update','AdminsController@profile')->name('system.admin.do.profile');

        });

//======================================================================================================
//                   Users Admin ROUTES
//======================================================================================================
        Route::prefix('users/')->middleware(['checkRule:view,users'])->group(function () {
            Route::get('', 'UserController@index')->name('system.users.index');
            Route::get('{id}/update', 'UserController@showUpdateView')->name('system.users.update')->middleware(['checkRule:edit,users']);
            Route::get('{id}/view', 'UserController@show')->name('system.users.details');
            Route::get('addresses/{id}', 'UserController@showUserAddresses')->name('user.addresses');
            Route::post('delete', 'UserController@delete')->name('system.users.delete')->middleware(['checkRule:delete,users']);
            Route::post('activate', 'UserController@activate')->name('system.users.activate')->middleware(['checkRule:activate,users']);
            Route::post('deactivate', 'UserController@deactivate')->name('system.users.deactivate')->middleware(['checkRule:activate,users']);
        });

//======================================================================================================
//                   Balance  ROUTES
//======================================================================================================
        Route::prefix('balance/')->middleware(['checkRule:view,balance'])->group(function () {
            Route::get('', 'BalanceController@user')->name('system.balance.index');
            Route::get('users/{id}/view', 'BalanceController@showUser')->name('system.balance.userBalance');

        });


//======================================================================================================
//                   Users transactions ROUTES
//======================================================================================================
        Route::prefix('transactions/')->middleware(['checkRule:view,transactions'])->group(function () {
            Route::get('', 'TransactionController@index')->name('system.transactions.index');
            Route::get('{id}/view', 'TransactionController@show')->name('system.transactions.details');
            Route::post('delete', 'TransactionController@delete')->name('system.transactions.delete')->middleware(['checkRule:delete,transactions']);
            Route::post('activate', 'TransactionController@activate')->name('system.transactions.activate')->middleware(['checkRule:activate,transactions']);
            Route::post('deactivate', 'TransactionController@deactivate')->name('system.transactions.deactivate')->middleware(['checkRule:activate,transactions']);
        });
        
        //======================================================================================================
//                   ads ROUTES
//======================================================================================================
        // Route::prefix('ads/')->middleware(['checkRule:view,ads'])->group(function () {
        //     Route::get('', 'Ads@ads')->name('system.ads.index');

        // });
        
        
Route::get('ads/', 'AdsController@ads')->name('system.ads.index');

      Route::post('adsData/create', 'AdsController@create')->name('system.ads.do.create');
    Route::post('/adData/delete/{text}/{type}', 'AdsController@delete_group')->name('system.ads.delete.group')->middleware(['checkRule:delete,ads']);
       Route::post('/adData/delete', "AdsController@delete")->name('system.ads.delete');
           Route::get('/ads/show_create', "AdsController@showCreateView")->name('system.ads.create');
//======================================================================================================
//                   notifications ROUTES
//======================================================================================================
        Route::prefix('notifications/')->middleware(['checkRule:view,notifications'])->group(function () {
            Route::get('', 'NotificationsController@notifications')->name('system.notifications.index');
            Route::get('show/{text}/{type}', 'NotificationsController@show')->name('system.notifications.show');
            Route::post('delete/{text}/{type}', 'NotificationsController@delete_group')->name('system.notifications.delete.group')->middleware(['checkRule:delete,notifications']);
            Route::post('delete_user', 'NotificationsController@delete_user')->name('system.notifications.delete.user')->middleware(['checkRule:delete,notifications']);
            Route::get('show_create', "NotificationsController@showCreateView")->name('system.notifications.create');
            Route::post('create', "NotificationsController@create")->name('system.notifications.do.create');
            Route::post('delete', "NotificationsController@delete")->name('system.notifications.delete');
            Route::get('show_create_user/{id}', "NotificationsController@showCreateUserView")->name('system.notifications.send_per_user');
            Route::get('show_create_driver/{id}', "NotificationsController@showCreateDriverView")->name('system.notifications.send_per_driver');
            Route::post('create_user', "NotificationsController@createPerUser")->name('system.notifications.do.send_per_user');
            Route::post('create_driver', "NotificationsController@createPerDriver")->name('system.notifications.do.send_per_driver');
        });
//======================================================================================================
//                   Users transactions ROUTES
//======================================================================================================
        Route::prefix('translation/')->middleware(['checkRule:view,translations'])->group(function () {
            Route::get('', 'TranslationController@index')->name('system.translations.index');
            Route::get('apiTexts', 'TranslationController@apiNotifications')->name('system.translations.apiTexts');
            Route::post('saveText', 'TranslationController@saveText')->name('system.translations.saveText')->middleware(['checkRule:edit,translations']);
            Route::post('saveApi', 'TranslationController@saveApi')->name('system.translations.saveApi')->middleware(['checkRule:edit,translations']);

        });

//======================================================================================================
//                   Users user_balances ROUTES
//======================================================================================================
        Route::prefix('user_balances/')->middleware(['checkRule:view,transactions'])->group(function () {
            Route::get('', 'TransactionController@user_balances')->name('system.user_balances.index');
            Route::get('{id}/view', 'TransactionController@show_user_balance')->name('system.user_balances.details');
            Route::post('activate', 'TransactionController@add_user_balance')->name('system.user_balances.add_balance')->middleware(['checkRule:activate,transactions']);
            Route::post('deactivate', 'TransactionController@sub_user_balance')->name('system.user_balances.sub_balance')->middleware(['checkRule:activate,transactions']);

        });



//======================================================================================================
//                   areas ROUTES
//======================================================================================================
        Route::prefix('countries/')->group(function () {

            Route::get('', 'CountriesController@index')->name('system.countries.index');

            Route::post('delete', 'CountriesController@delete')->name('system.countries.delete')->middleware(['checkRule:delete,countries']);

            Route::get('create', 'CountriesController@showCreateView')->name('system.countries.create');

            Route::post('create', "CountriesController@create")->name('system.countries.do.create');

            Route::post('update/{id}', 'CountriesController@Update')->name('system.countries.do.update');

            Route::get('{id}/update', 'CountriesController@showUpdateView')->name('system.countries.update');
            Route::post('activate', 'CountriesController@activate')->name('system.countries.activate')->middleware(['checkRule:activate,countries']);

            Route::post('deactivate', 'CountriesController@deactivate')->name('system.countries.deactivate')->middleware(['checkRule:activate,countries']);
        });

        Route::prefix('areas/')->middleware(['checkRule:view,areas'])->group(function () {

            Route::get('index', 'AreasController@index')->name('system.areas.index');
            Route::post('add_country', "AreasController@add_country")->name('system.areas.add_country')->middleware(['checkRule:add,areas']);//
            Route::post('add_city', "AreasController@add_city")->name('system.areas.add_city')->middleware(['checkRule:add,areas']);//
            Route::post('edit_country', 'AreasController@edit_country')->name('system.areas.edit_country')->middleware(['checkRule:edit,areas']);
            Route::post('edit_city', 'AreasController@edit_city')->name('system.areas.edit_city')->middleware(['checkRule:edit,areas']);
            Route::post('delete_country', 'AreasController@delete_country')->name('system.areas.delete_country')->middleware(['checkRule:delete,areas']);
            Route::post('delete_city', 'AreasController@delete_city')->name('system.areas.delete_city')->middleware(['checkRule:delete,areas']);
            Route::post('delete_division', 'AreasController@delete_division')->name('system.areas.delete_division')->middleware(['checkRule:delete,areas']);
            Route::get('show_create', "AreasController@showCreateView")->name('system.areas.create')->middleware(['checkRule:add,areas']);
            Route::post('create', "AreasController@create")->name('system.areas.do.create')->middleware(['checkRule:add,areas']);//
            Route::get('{id}/update/{type}', 'AreasController@showUpdateView')->name('system.areas.update')->middleware(['checkRule:edit,areas']);
            Route::post('update/{id}', 'AreasController@Update')->name('system.areas.do.update')->middleware(['checkRule:edit,areas']);
            Route::get('edit_prices/{id}', 'AreasController@showPricesView')->name('system.areas.edit_prices')->middleware(['checkRule:edit,areas']);
            Route::post('edit_prices', 'AreasController@UpdatePrices')->name('system.areas.do.updatePrices')->middleware(['checkRule:edit,areas']);

        });

//======================================================================================================
//                   categories ROUTES
//======================================================================================================

        Route::prefix('categories/')->middleware(['checkRule:view,categories'])->group(function () {
            Route::get('', 'CategoryController@index')->name('system.categories.index');
            Route::get('show_create', "CategoryController@showCreateView")->name('system.categories.create')->middleware(['checkRule:add,categories']);
            Route::post('create', "CategoryController@create")->name('system.categories.do.create')->middleware(['checkRule:add,categories']);//
            Route::get('{id}/update', 'CategoryController@showUpdateView')->name('system.categories.update')->middleware(['checkRule:edit,categories']);
            Route::post('update/{id}', 'CategoryController@Update')->name('system.categories.do.update')->middleware(['checkRule:edit,categories']);
            Route::post('delete', 'CategoryController@delete')->name('system.categories.delete')->middleware(['checkRule:delete,categories']);
            Route::post('createJson', "CategoryController@createJson")->name('system.categories.createJson')->middleware(['checkRule:add,categories']);//
            Route::post('sort_category', "CategoryController@sortCategory")->name('system.categories.sortCategory');


        });

//======================================================================================================
//                   categories ROUTES
//======================================================================================================

        Route::prefix('drivers/')->middleware(['checkRule:view,drivers'])->group(function () {
            Route::get('', 'DriverController@index')->name('system.drivers.index');
            Route::get('{id}/view', 'DriverController@show')->name('system.drivers.details');
            Route::get('show_create', "DriverController@showCreateView")->name('system.drivers.create')->middleware(['checkRule:add,drivers']);
            Route::post('create', "DriverController@create")->name('system.drivers.do.create')->middleware(['checkRule:add,drivers']);//
            Route::get('{id}/orders', 'DriverController@orders')->name('system.drivers.orders');
            Route::get('{id}/update', 'DriverController@showUpdateView')->name('system.drivers.update')->middleware(['checkRule:edit,drivers']);
            Route::post('update/{id}', 'DriverController@Update')->name('system.drivers.do.update')->middleware(['checkRule:edit,drivers']);
            Route::post('delete', 'DriverController@delete')->name('system.drivers.delete')->middleware(['checkRule:delete,drivers']);
            Route::post('activate', 'DriverController@activate')->name('system.drivers.activate')->middleware(['checkRule:activate,drivers']);
            Route::post('deactivate', 'DriverController@deactivate')->name('system.drivers.deactivate')->middleware(['checkRule:activate,drivers']);
            Route::post('createJson', "DriverController@createJson")->name('system.drivers.createJson')->middleware(['checkRule:add,drivers']);//

        });
        //======================================================================================================
//                   cut_types ROUTES
//======================================================================================================

        Route::prefix('cut_types/')->middleware(['checkRule:view,cut_types'])->group(function () {
            Route::get('', 'CutTypeController@index')->name('system.cut_types.index');
            Route::get('show_create', "CutTypeController@showCreateView")->name('system.cut_types.create')->middleware(['checkRule:add,cut_types']);
            Route::post('create', "CutTypeController@create")->name('system.cut_types.do.create')->middleware(['checkRule:add,cut_types']);//
            Route::get('{id}/update', 'CutTypeController@showUpdateView')->name('system.cut_types.update')->middleware(['checkRule:edit,cut_types']);
            Route::post('update/{id}', 'CutTypeController@Update')->name('system.cut_types.do.update')->middleware(['checkRule:edit,cut_types']);
            Route::post('delete', 'CutTypeController@delete')->name('system.cut_types.delete')->middleware(['checkRule:delete,cut_types']);
            Route::post('activate', 'CutTypeController@activate')->name('system.cut_types.activate')->middleware(['checkRule:activate,cut_types']);
            Route::post('deactivate', 'CutTypeController@deactivate')->name('system.cut_types.deactivate')->middleware(['checkRule:activate,cut_types']);
        });

//======================================================================================================
//                   coupons ROUTES
//======================================================================================================
        Route::prefix('coupons/')->middleware(['checkRule:view,coupons'])->group(function () {
            Route::get('', 'CouponController@index')->name('system.coupons.index');
            Route::get('show_create', "CouponController@showCreateView")->name('system.coupons.create')->middleware(['checkRule:add,coupons']);
            Route::post('create', "CouponController@create")->name('system.coupons.do.create')->middleware(['checkRule:add,coupons']);//
            Route::post('delete', 'CouponController@delete')->name('system.coupons.delete')->middleware(['checkRule:delete,coupons']);
            Route::post('activate', 'CouponController@activate')->name('system.coupons.activate')->middleware(['checkRule:activate,coupons']);
            Route::post('deactivate', 'CouponController@deactivate')->name('system.coupons.deactivate')->middleware(['checkRule:deactivate,coupons']);
        });

//======================================================================================================
//                  ROUTES products
//======================================================================================================
        Route::prefix('products/')->middleware(['checkRule:view,products'])->group(function () {
            Route::get('', 'ProductController@index')->name('system.products.index');
            Route::get('{id}/view', 'ProductController@show')->name('system.products.details');
            Route::get('{id}/show-added-variants', 'ProductController@showAddedVariants')->name('system.products.showAddedVariants');
            Route::get('{id}/update', 'ProductController@showUpdateView')->name('system.products.update')->middleware(['checkRule:edit,products']);
            Route::post('{id}/update', 'ProductController@Update')->name('system.products.do.update');
            Route::get('show_create', "ProductController@showCreateView")->name('system.products.create')->middleware(['checkRule:add,products']);
            Route::post('editVariantsQty', "ProductController@editVariantsQty")->name('system.products.do.editVariantsQty')->middleware(['checkRule:add,products']);
            Route::post('deleteAddedVariant', "ProductController@deleteAddedVariant")->name('system.products.do.deleteAddedVariant')->middleware(['checkRule:add,products']);
            Route::post('create', "ProductController@create")->name('system.products.do.create')->middleware(['checkRule:add,products']);
            Route::post('delete', 'ProductController@delete')->name('system.products.delete')->middleware(['checkRule:delete,products']);
            Route::post('activate', 'ProductController@activate')->name('system.products.activate')->middleware(['checkRule:activate,products']);
            Route::post('deactivate', 'ProductController@deactivate')->name('system.products.deactivate')->middleware(['checkRule:activate,products']);
            Route::post('change_offer_status', 'ProductController@change_offer_status')->name('system.products.change_offer_status')->middleware(['checkRule:edit,products']);
            Route::post('change_slider_status', 'ProductController@change_slider_status')->name('system.products.change_slider_status')->middleware(['checkRule:edit,products']);
            Route::post('change_recent_status', 'ProductController@change_recent_status')->name('system.products.change_recent_status')->middleware(['checkRule:edit,products']);
            Route::post('delete_image', 'ProductController@delete_image')->name('system.products.delete_image')->middleware(['checkRule:edit,products']);
            Route::post('delete_image1', 'ProductController@delete_image1')->name('system.products.delete_image1')->middleware(['checkRule:edit,products']);
            Route::post('upload_image', 'ProductController@saveMultiFileJson')->name('system.products.upload_image')->middleware(['checkRule:edit,products']);
            Route::post('upload_image1', 'ProductController@saveMultiFileJson1')->name('system.products.upload_image1')->middleware(['checkRule:edit,products']);
            Route::post('default_image', 'ProductController@defaultIMG')->name('system.products.default_image')->middleware(['checkRule:edit,products']);
            Route::get('{id}/view-logs', 'ProductController@productLogs')->name('system.products.productLogs');
            Route::get('add_qty/{product_id}', "ProductController@showCreateLogView")->name('system.products.create_log')->middleware(['checkRule:add,products']);
            Route::post('create_log', "ProductController@createProductLog")->name('system.products.do.create_log')->middleware(['checkRule:add,products']);

        });


        //======================================================================================================
//                  ROUTES product variants
//======================================================================================================
        Route::prefix('product-variants/')->middleware(['checkRule:view,product_variants'])->group(function () {
            Route::get('{id}', 'ProductVariantController@index')->name('system.product_variants.index');
            Route::get('{id}/show-added-variants', 'ProductVariantController@showAddedVariants')->name('system.product_variants.showAddedVariants');
            Route::get('show_create/{id}', "ProductVariantController@showCreateView")->name('system.product_variants.create')->middleware(['checkRule:add,product_variants']);
            Route::post('editVariantsQty', "ProductVariantController@editVariantsQty")->name('system.product_variants.editVariantsQty')->middleware(['checkRule:add,product_variants']);
            Route::post('create', "ProductVariantController@create")->name('system.product_variants.do.create')->middleware(['checkRule:add,product_variants']);
            Route::post('delete', 'ProductVariantController@delete')->name('system.product_variants.delete')->middleware(['checkRule:delete,product_variants']);
            Route::post('deactivate', 'ProductVariantController@deactivate')->name('system.product_variants.deactivate')->middleware(['checkRule:activate,product_variants']);
            Route::post('activate', 'ProductVariantController@activate')->name('system.product_variants.activate')->middleware(['checkRule:activate,product_variants']);
            Route::get('{id}/update', 'ProductVariantController@showUpdateView')->name('system.product_variants.update')->middleware(['checkRule:edit,product_variants']);
            Route::post('update', 'ProductVariantController@Update')->name('system.product_variants.do.update');
        });


//======================================================================================================
//                   Pages ROUTES
//======================================================================================================
        Route::prefix('pages/')->middleware(['checkRule:view,pages'])->group(function () {
            Route::get('', 'PagesController@index')->name('system.pages.index');
            Route::get('{id}/update', 'PagesController@showUpdateView')->name('system.pages.update')->middleware(['checkRule:edit,pages']);
            Route::post('update/{id}', 'PagesController@Update')->name('system.pages.do.update')->middleware(['checkRule:edit,pages']);
        });

//======================================================================================================
//                   contacts ROUTES
//======================================================================================================
        Route::prefix('contacts/')->middleware(['checkRule:view,contacts'])->group(function () {
            Route::get('', 'ContactsController@index')->name('system.contacts.index');
            Route::post('delete', 'ContactsController@delete')->name('system.contacts.delete')->middleware(['checkRule:delete,contacts']);
            Route::post('replay', 'ContactsController@contactReplay')->name('system.contacts.replay');
        });
//======================================================================================================
//                   Orders ROUTES
//======================================================================================================
        Route::prefix('orders/')->group(function () {
            Route::get('', 'OrdersController@index')->name('system.orders.index');
            Route::get('mainIndex', 'OrdersController@mainIndex')->name('system.orders.mainIndex');
            Route::get('archive', 'OrdersController@archive')->name('system.orders.archive');
            Route::get('canceled', 'OrdersController@canceled')->name('system.orders.canceled');

            Route::post('refund_canceled_order', 'OrdersController@refundCanceledOrder')->name('system.orders.refundCanceledOrder')->middleware(['checkRule:edit,orders']);
            Route::get('{id}/track-order', 'OrdersController@trackOrderOnMap')->name('system.orders.trackOrderOnMap');

            Route::get('store', 'OrdersController@index2')->name('system.orders.store');
            Route::get('details/{id}', 'OrdersController@details')->name('system.orders.details');
            Route::post('change_order_status_to_one', 'OrdersController@change_order_status_to_one')->name('system.orders.change_order_status_to_one')->middleware(['checkRule:edit,orders']);
            Route::post('change_order_status_to_tow', 'OrdersController@change_order_status_to_tow')->name('system.orders.change_order_status_to_tow')->middleware(['checkRule:edit,orders']);
            Route::post('change_order_status_to_three', 'OrdersController@change_order_status_to_three')->name('system.orders.change_order_status_to_three')->middleware(['checkRule:edit,orders']);
            Route::post('change_order_status_to_prepared', 'OrdersController@change_order_status_to_prepared')->name('system.orders.change_order_status_to_prepared')->middleware(['checkRule:edit,orders']);
            Route::post('change_order_status_to_can', 'OrdersController@change_order_status_to_can')->name('system.orders.change_order_status_to_can')->middleware(['checkRule:edit,orders']);
            Route::post('delete', 'OrdersController@delete')->name('system.orders.delete')->middleware(['checkRule:delete,orders']);
            Route::get('new_row', 'OrdersController@new_row')->name('system.orders.new_row');
            Route::get('new_row_2', 'OrdersController@new_row_2')->name('system.orders.new_row_2');
        });

        Route::prefix('ratings/')->middleware(['checkRule:view,rates'])->group(function () {
            Route::get('', 'RatingController@index')->name('system.ratings.index');
            Route::get('{id}/view', 'RatingController@show')->name('system.ratings.show');
            Route::post('accept-review', 'RatingController@accept')->name('system.ratings.accept')->middleware(['checkRule:activate,orders']);
            Route::post('decline-review', 'RatingController@decline')->name('system.ratings.decline')->middleware(['checkRule:activate,orders']);
        });
//======================================================================================================
//                   reports ROUTES
//======================================================================================================
        Route::prefix('reports/')->middleware(['checkRule:view,reports'])->group(function () {
            Route::get('', 'ReportController@index')->name('system.reports.index');
            Route::get('R1', 'ReportController@report1')->name('system.reports.r1');
            Route::get('R2', 'ReportController@report2')->name('system.reports.r2');
            Route::get('R3', 'ReportController@report3')->name('system.reports.r3');
            Route::get('R4', 'ReportController@report4')->name('system.reports.r4');
            Route::get('R5', 'ReportController@report5')->name('system.reports.r5');
            Route::get('R6', 'ReportController@report6')->name('system.reports.r6');
        });

//======================================================================================================

//                   sizes ROUTES

//======================================================================================================



        Route::prefix('sizes/')->middleware(['checkRule:view,sizes'])->group(function () {

            Route::get('', 'SizeController@index')->name('system.sizes.index');

            Route::post('delete', 'SizeController@delete')->name('system.sizes.delete')->middleware(['checkRule:delete,sizes']);

            Route::post('createJson', "SizeController@createJson")->name('system.sizes.createJson')->middleware(['checkRule:add,sizes']);//

            Route::post('createj', "SizeController@createj")->name('system.sizes.do.createj')->middleware(['checkRule:add,sizes']);//

            Route::post('updatej', "SizeController@updatej")->name('system.sizes.do.updatej')->middleware(['checkRule:edit,sizes']);//

            Route::get('getInfo', 'SizeController@getInfo')->name('system.sizes.getInfo')->middleware(['checkRule:edit,sizes']);



        });


    });

    Route::get('getSizes', 'SizeController@getSizes')->name('admin.getSizes');
    Route::get('getProductImages', 'ProductController@getProductImages')->name('admin.getProductImages');
    Route::post('upload-image-ajax', "ProductVariantController@uploadImageAjax")->name('system.product_variants.uploadImageAjax');
      Route::get('get_divisions', 'AreasController@get_divisions')->name('system.areas.get_divisions');


    Route::get('start_mada_transaction', 'MadaController@index')->name('mada.start_transaction');
    Route::get('start_hyperpay_transaction', 'HyperPayController@index')->name('hyper.start_transaction');
    Route::get('return_from_transaction', 'HyperPayController@return_from_transaction')->name('hyper.return');

//======================================================================================================
//                   Others ROUTES
//======================================================================================================
    Route::post('uploadFile', "MediaController@saveFileJson");
    Route::post('uploadVideo', "MediaController@saveVideoJson");
    Route::post('uploadFiles', "MediaController@saveMultiFileJson");
    Route::post('uploadFiles1', "MediaController@saveMultiFileJson1");
Route::post('uploadFilesNew', "MediaController@saveMultiFileJsonNew");



Route::prefix('commands/')->middleware(['auth:system_admin','checkRule:view,admins'])->group(function () {
        Route::get('migrate',"ClosureController@migrate");
        Route::get('generate_models',"ClosureController@generate_models");

        Route::get('clear',"ClosureController@clearView");
        Route::get('changeKey',"ClosureController@changeKey");
        Route::get('ChangeToProduction',"ClosureController@ChangeToProduction");
        Route::get('ChangeToDevelopment',"ClosureController@ChangeToDevelopment");


    });

    Route::get('/test-image',function(){
        dd(HELPER::getImageWidth('1594904086_505427192.jpg'));
    });

    Route::get('down',"ClosureController@down")->name('api.down');
//});

Route::get('/artisan/generate_docs',function(){ 
    Artisan::call('l5-swagger:generate'); 
    echo "<h1>Generating Done</h1>";
});
Route::get('/artisan/seed',function(){
    Artisan::call('db:seed'); 
    echo "<h1>seeding Done</h1>";
});
Route::get('/test_variant',function(){
    $keyy=Settings::where('name','firebase_key')->first();

    $api_key = $keyy->value;
    // $api_url = 'https://fcm.googleapis.com/fcm/send';
    $api_url = 'https://android.googleapis.com/gcm/send';
 
    $push = ['title_ar'=>'test12','message_ar'=>'test12'];
    $pdata = ['title_ar'=>'test12','message_ar'=>'testweb'];
    $fields = array('notification' => $push, 'data' => $pdata, 'to' => 'ehm9rQbaSSSsX_Q13XXG8M:APA91bGXPG27X9YYqWE_zmz-oZ8-E_MafPn_hUMmvQzqxHri7GrJ-zo5eGRSU5m8dCgE5fAE1xq3_4eUx-2cUPkspMmEkHC98jb0lf3np-1l0M9lihIJV2f9mIwpS6yYgnl72Z4mjSO4', 'priority' => "high", "content_available" => true);
    $headers = array('Authorization:key=' . $api_key, 'Content-Type: application/json');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    if ($result === false)
        die('Curl failed ' . curl_error($ch));
    curl_close($ch);
    dd($result);
////     ;
//$cover_types = Variant::where('variant_type_id',3)->pluck('id')->toArray();
//        $cover_types[]=0;
//     $cover_types = Order::where('user_id', 13)
//         ->where('total_price', 1818)
//         ->where(function ($q){
//             $q->where(function ($q1){
//                 $q1->where('payment_type','>',1)
//                     ->where('is_paid',1);
//             })
//                 ->orwhere(function ($q1){
//                     $q1->where('payment_type',1)
//                     ;
//                 });
//         })
//         ->where('created_at', '>', Carbon::now()->subMinutes(45))->count();
// dd($cover_types,Carbon::now()->subMinutes(45));
});
//======================================================================================================
//                   template ROUTES
//======================================================================================================

Route::prefix('template/')->middleware(['checkRule:view,template'])->group(function () {
    Route::get('', 'TemplateController@index')->name('system.template.index');
    Route::get('show_create', "TemplateController@showCreateView")->name('system.template.create')->middleware(['checkRule:add,template']);
    Route::post('create', "TemplateController@create")->name('system.template.do.create')->middleware(['checkRule:add,template']);//
    Route::get('{id}/update', 'TemplateController@showUpdateView')->name('system.template.update')->middleware(['checkRule:edit,template']);
    Route::post('update/{id}', 'TemplateController@Update')->name('system.template.do.update')->middleware(['checkRule:edit,template']);
    Route::post('delete', 'TemplateController@delete')->name('system.template.delete')->middleware(['checkRule:delete,template']);
});






//======================================================================================================
//                  ROUTES template with multi upload
//======================================================================================================
Route::prefix('templates/')->middleware(['checkRule:view,templates'])->group(function () {
    Route::get('', 'TemplateController@index')->name('system.templates.index');
    Route::get('{id}/view', 'TemplateController@show')->name('system.templates.details');
    Route::get('{id}/update', 'TemplateController@showUpdateView')->name('system.templates.update')->middleware(['checkRule:edit,templates']);
    Route::post('{id}/update', 'TemplateController@Update')->name('system.templates.do.update');
    Route::get('show_create', "TemplateController@showCreateView")->name('system.templates.create')->middleware(['checkRule:add,templates']);
    Route::post('create', "TemplateController@create")->name('system.templates.do.create')->middleware(['checkRule:add,templates']);
    Route::post('delete', 'TemplateController@delete')->name('system.templates.delete')->middleware(['checkRule:delete,templates']);
    Route::post('activate', 'TemplateController@activate')->name('system.templates.activate')->middleware(['checkRule:activate,templates']);
    Route::post('deactivate', 'TemplateController@deactivate')->name('system.templates.deactivate')->middleware(['checkRule:activate,templates']);
    Route::post('delete_image', 'TemplateController@delete_image')->name('system.templates.delete_image')->middleware(['checkRule:edit,templates']);
    Route::post('upload_image', 'TemplateController@saveMultiFileJson')->name('system.templates.upload_image')->middleware(['checkRule:edit,templates']);
    Route::post('default_image', 'TemplateController@defaultIMG')->name('system.templates.default_image')->middleware(['checkRule:edit,templates']);


});


//======================================================================================================
//                  ROUTES test
//======================================================================================================
Route::prefix('test/')->middleware(['checkRule:view,test'])->group(function () {
    Route::get('', 'TestController@index')->name('system.test.index');
    Route::get('{id}/view', 'TestController@show')->name('system.test.details');
    Route::get('{id}/update', 'TestController@showUpdateView')->name('system.test.update')->middleware(['checkRule:edit,test']);
    Route::post('{id}/update', 'TestController@Update')->name('system.test.do.update');
    Route::get('show_create', "TestController@showCreateView")->name('system.test.create')->middleware(['checkRule:add,test']);
    Route::post('create', "TestController@create")->name('system.test.do.create')->middleware(['checkRule:add,test']);
    Route::post('delete', 'TestController@delete')->name('system.test.delete')->middleware(['checkRule:delete,test']);
    Route::post('activate', 'TestController@activate')->name('system.test.activate')->middleware(['checkRule:activate,test']);
    Route::post('deactivate', 'TestController@deactivate')->name('system.test.deactivate')->middleware(['checkRule:activate,test']);


});

Route::any('api/urway_payment', "PaymentController@index")->name('payment');
Route::any('api/urway_return', "PaymentController@success")->name('payment.success');
Route::any('api/urway_fail', "PaymentController@fail")->name('payment.fail');
Route::any('api/urway_success', "PaymentController@successdone")->name('payment.success.done');

 function result()
	{
	    
	    echo '
	    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title>Invoice</title>
 <link rel=stylesheet type=text/css href= style.css />
</head>

<body>
    <div id="page-wrap">
        <textarea id="header">INVOICE</textarea>
        <div id="identity">
            <label id="address">
                SAUDI ARABIA
            </label>

            <!--div id="logo">
                <img src="https://urway.sa/wp-content/uploads/2019/06/Logo-300x150.png" alt="logo" />
            </div-->

        </div>

        <div style="clear:both"></div>

        <div id="customer">

            <label id="customer-title">Sample Receipt
</label>

            <table id="meta">
                <tr>
                    <td class="meta-head">Payment id #</td>
                    <td><textarea>'.$_GET['PaymentId'].'</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">Result</td>
                    <td>';
                         if($_GET['Result'] == 'Successful'||$_GET['Result'] == 'Success')
                    {
                        echo '<div class="due" style="color:white ; background-color: green;">'.$_GET['Result'].'</div>';
                    }
                    else
                     echo'  <div class="due" style="color:white ; background-color: red;">'.$_GET['Result'].'</div>';
                echo' 
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">Response Code</td>
                    <td>
                        <div class="due">'.$_GET['ResponseCode'].'</div>
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">Auth Code</td>
                    <td>
                        <div class="due">'.$_GET['AuthCode'].'</div>
                    </td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><textarea id="date">'.date('d-m-Y H:i:s a').'</textarea></td>
                </tr>
                <tr>
                    <td class="meta-head">CardBrand</td>
                    <td><textarea id="date">'.$_GET['cardBrand'].' </textarea></td>
                </tr>
                

            </table>

        </div>

        <table id="items">

            <tr>
                <th>Item</th>
                <th>Description</th>
                <!--th>Unit Cost</th>
                <th>Quantity</th-->
                <th>Price</th>
            </tr>

            <tr class="item-row">
                <td class="item-name">
                    <div><label><?php echo Sample Item ?></label></div>
                </td>
                <td class="description"><label></label></td>
          
                <td colspan="3"><span class="price">'.$_GET['amount'].'</span></td>
            </tr>
            <tr>
                <td colspan="2" class="blank"> </td>
                <td colspan="1" class="total-line">Amount Paid</td>

                <td class="total-value"><textarea id="paid">'.$_GET['amount'].'</textarea></td>
            </tr>
        </table>

        <div id="terms">
            <!--a href="/urshop/" class="">Back to Store</a-->
        </div>

    </div>

</body>

</html>
	    ';
	    
	}
	


Route::post('/add_drivre', 'WebsiteController@add_driver')->name('add_drivre');


    Route::get('driver_register', function(){
        
 $govs= \App\Models\Gov::all();
        return view('register_driver',compact('govs'));

    })->name('system.test.index');
Route::get('/terms', 'WebsiteController@privacy')->name('website.terms');


Route::get('/privacy', 'WebsiteController@privacy')->name('website.privacy');
