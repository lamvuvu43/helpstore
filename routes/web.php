<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/admin-store', 'AdminTemplateController@index')->name('admin_store.index');
Route::get('/gettable/api','APIController@getTable');
Route::group(['prefix' => 'admin/admin-store', 'middleware' => 'auth'], function () {
    Route::get('/redirect_url', 'RedirectUrlLoginController@redirect_url')->name('redirect_url');

    Route::get('/restaurant', 'RestaurantController@index')->name('form.add.restaurant');
    Route::post('/add-restaurant-process', 'RestaurantController@store')->name('add.process.restaurant');
    Route::get('/list-restaurant', 'RestaurantController@show')->name('list.restaurant');
    Route::delete('/delete-restaurant/{id}', 'RestaurantController@destroy')->name('destroy.restaurant');
    Route::post('/edit-restaurant', 'RestaurantController@update')->name('update.restaurant');

    Route::get('/create-staff', 'StaffController@create')->name('create.staff');
    Route::post('/create-staff/process', 'StaffController@store')->name('create.staff.store');
    Route::get('/list-staff', 'StaffController@index')->name('list.stafd.index');
    Route::get('/list-staff-show/{id_res}', 'StaffController@show')->name('list.staff.show');
    Route::post('/list-staff-update', 'StaffController@update')->name('list.stafd.update');
    Route::delete('/staff-delete/{id}', 'StaffController@destroy')->name('stafd.destroy');

    Route::get('/create-food', 'FoodController@create')->name('create.food');
    Route::post('/create-food/process', 'FoodController@store')->name('create.food.store');
    Route::get('/list-food', 'FoodController@index')->name('list.food.index');
    Route::get('/list-food/show/{id_res}', 'FoodController@show')->name('list.food.show');
    Route::post('/list-food-update', 'FoodController@update')->name('list.food.update');
    Route::delete('/food-delete/{id_food}', 'FoodController@destroy')->name('food.destroy');
    Route::get('/food-edit_image/{id_food}', 'FoodController@edit_image_show')->name('edit_image_show');
    Route::post('/food-edit_image/process', 'FoodController@update_image')->name('update_image_process');
    Route::post('/food-add_image/process/{id_d}', 'FoodController@add_image_food')->name('add_image_process');

    Route::get('/create_order', 'OrderController@create')->name('order.create');
    Route::get('/create_order_get_list/food/{id_res}', 'OrderController@show')->name('create_order_get_list_food');
    Route::post('/create_order/choose/food', 'OrderController@store')->name('choose_food');
    Route::get('/create_order/get_list/choose/{id_res}', 'OrderController@index')->name('list_food_choose');
    Route::post('/create_order/send-requied/{id_res}', 'OrderController@send_required')->name('send_required');
    Route::post('/create_order/update_temp/{id_temp}', 'OrderController@update')->name('temp_update');
    Route::post('/create_order/update_temp_note_f/{id_temp}', 'OrderController@update_note_f')->name('temp_update_note_f');
    Route::delete('create_order/delete_temp/{id_temp}', 'OrderController@destroy')->name('destroy_temp');
    Route::get('/create_order/get_name_res/{id_res}', 'OrderController@get_name_res')->name('get_name_res');
    Route::get('/create_order/get_list_table/{id_res}', 'OrderController@get_table')->name('create_order_list_table');
    Route::get('/list_order', 'OrderController@list')->name('list_order');
    Route::get('/list_order/filter/{filter}/{id_res}/{todate}', 'OrderController@filter_list')->name('list_order_filter');
    Route::get('/list_order/update_stauts/{status}/{id_b}', 'OrderController@update_status')->name('list_update_status');
    Route::get('/list_order/detail/{id_bil}', 'OrderController@detail_bill')->name('detail_bill');


    Route::post('/order_autocomplete/{id_res}', 'SearchController@order_food_with_res')->name('search.food.by.res');

    Route::get('/create_table', 'TableController@create')->name('table_create');
    Route::post('/create_table/process', 'TableController@store')->name('table_store');
    Route::get('/list_tabel', 'TableController@index')->name('table_list');
    Route::get('/list_tabel/{id_res}', 'TableController@show')->name('table_list_id_res');
    Route::post('/list_table/update/process', 'TableController@update')->name('table_update');
    Route::delete('/list_table/delete/{id_table}', 'TableController@destroy')->name('table_delete');
});

Route::group(['prefix' => 'admin/staff-store', 'middlewara' => 'auth'], function () {
    Route::get('/create_order', 'StaffOrderController@create')->name('staff.create_order');
    Route::post('/create_order/choose/staff_food', 'StaffOrderController@store')->name('staff.choose_food');
    Route::get('/staff_list_order/{id}','StaffOrderController@show')->name('staff.order_show');
    Route::get('/staff_list_order/{filter}/{id_res}','StaffOrderController@filter_list')->name('staff.filter_list');
});
