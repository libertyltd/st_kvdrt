<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\Http\Middleware\SEO;

Route::get('/', 'FrontEndController@index')->middleware(SEO::class);

Route::get('/sitemap.xml', 'FrontEndController@sitemap');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::post('/constructor/step/2', 'FrontEndController@constructor_step_2');
Route::get('/constructor/step/3/{id}', 'FrontEndController@constructor_step_3');
Route::post('/constructor/step/4', 'FrontEndController@constructor_step_4');
Route::post('/constructor/step/5', 'FrontEndController@constructor_step_5');

/**
 * Рутируем на блог
 */
Route::group(['middleware' => SEO::class], function () {
    Route::get('/blog', 'FrontEndController@blog_list');
    Route::get('/blog/{id}', 'FrontEndController@blog_item');
    Route::post('/blog/{id}', 'FrontEndController@blog_item_comment');
});


Route::group(['middleware' => 'auth'], function() {
    /**
     * Управление разделом Блог и комментариями к постам
     */
    Route::resource('/home/posts', 'PostController');
    Route::resource('/home/post_comments', 'PostCommentController');

    /**
     * Управление описанием раздела проделанных работ
     */
    Route::resource('/home/work_description', 'WorkDescriptionController');

    /**
     * Управление контактными данными компании
     */
    Route::resource('/home/contacts', 'ContactController');

    /**
     * Управление слайдами главной страницы
     */
    Route::resource('/home/sliders', 'SliderController');

    /**
     * Управление отзывами
     */
    Route::resource('/home/feedbacks', 'FeedBackController');

    /**
     * Управление выполненными работами
     */
    Route::resource('/home/works', 'WorkController');

    /**
     * Управление справочником по типам зданий
     */
    Route::resource('/home/type_buildings', 'TypeBuildingController');

    /**
     * Управление справочником по типам санузлов
     */
    Route::resource('/home/type_bathrooms', 'TypeBathroomController');

    /**
     * Управление дизайном
     */
    Route::resource('/home/designs', 'DesignController');

    /**
     * Управление дополнительными опциями
     */
    Route::resource('/home/options', 'OptionController');

    /**
     * Управление категориями дизайна
     */
    Route::resource('/home/category_designs', 'CategoryDesignController');

    /**
     * Управление опциями категории дизайна
     */
    Route::resource('/home/design_options', 'DesignOptionController');

    /**
     * Управление заказами
     */
    Route::resource('/home/orders', 'OrderController');

    /**
     * Управление SEO данными
     */
    Route::resource('/home/seos', 'SEOsController');


    /**
     * Управление правами доступа
     */
    Route::get('/home/permissions/', 'RolePermissionController@index');
    Route::get('/home/permissions/add/', 'RolePermissionController@add');
    Route::post('/home/permissions/add/', 'RolePermissionController@add');
    Route::get('/home/permissions/{id}/edit/', 'RolePermissionController@edit');
    Route::post('/home/permissions/{id}/edit/', 'RolePermissionController@edit');
    Route::delete('/home/permissions/{id}/delete/', 'RolePermissionController@delete');

    /**
     * Управление пользователями
     */
    Route::resource('/home/users', 'UserController');

    /**
     * Управление ролями перепишем вручную, так как у нас все отказывается работать
     * с не инкрементируемыми первичными ключами
     */
    //Route::resource('/home/roles/', 'RolesController');
    Route::get('/home/roles', 'RolesController@index');
    Route::get('/home/roles/create', 'RolesController@create');
    Route::post('/home/roles', 'RolesController@store');
    Route::get('/home/roles/{name_role}', 'RolesController@show');
    Route::get('/home/roles/{name_role}/edit', 'RolesController@edit');
    Route::put('/home/roles/{name_role}', 'RolesController@update');
    Route::delete('/home/roles/{name_role}', 'RolesController@destroy');

});
