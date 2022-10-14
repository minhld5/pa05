<?php

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

//Home
route::get('/','homeController@index');
route::post('doLogin','homeController@doLogin');

//Admin
// route::get('/admin/home','App\Http\Controllers\adminController@index');
// route::get('/admin/logout','App\Http\Controllers\adminController@logout');

$router->group(['prefix'=>'admin'], function() use($router){
   $router->get('/home', 'adminController@index');
   $router->get('/logout', 'adminController@logout');
   $router->get('/change_password', 'adminController@change_password');
   $router->post('/change_password', 'adminController@change_password_submit');
   $router->get('/system_config', 'adminController@system_config');
   $router->post('/system_config', 'adminController@system_config_submit');
   $router->get('/git_pull', 'adminController@git_pull');
});

//Thêm sửa xóa account
//role admin
$router->group(['prefix'=>'admin/account'], function() use($router){
   $router->get('/list', 'accountController@list');
   $router->get('/create', 'accountController@create');
   $router->post('/create', 'accountController@create_submit');
   $router->get('/edit/{id}', 'accountController@edit');
   $router->post('/edit/{id}', 'accountController@edit_submit');
   $router->get('/delete/{id}', 'accountController@delete');
   $router->get('/disable/{id}', 'accountController@disable');
   $router->get('/enable/{id}', 'accountController@enable');
   $router->get('/reset_password/{id}', 'accountController@reset_password');
});

//Thêm sửa xóa unit
//role admin
$router->group(['prefix'=>'admin/unit'], function() use($router){
   $router->get('/list', 'unitController@list');
   $router->get('/create', 'unitController@create');
   $router->post('/create', 'unitController@create_submit');
   $router->get('/edit/{id}', 'unitController@edit');
   $router->post('/edit/{id}', 'unitController@edit_submit');
   $router->get('/delete/{id}', 'unitController@delete');
});

//Thêm sửa xóa department
//role admin
$router->group(['prefix'=>'admin/department'], function() use($router){
   $router->get('/list/{sys_unit_id}', 'departmentController@list');
   $router->get('/create/{sys_unit_id}', 'departmentController@create');
   $router->post('/create/{sys_unit_id}', 'departmentController@create_submit');
   $router->get('/edit/{id}', 'departmentController@edit');
   $router->post('/edit/{id}', 'departmentController@edit_submit');
   $router->get('/delete/{id}', 'departmentController@delete');
});

//User
$router->group(['prefix'=>'user'], function() use($router){
   $router->get('/home', 'userController@index');
   $router->get('/logout', 'userController@logout');
   $router->get('/change_password', 'userController@change_password');
   $router->post('/change_password', 'userController@change_password_submit');
});

//Thêm sửa xóa nhóm sản phẩm
//role pm pa05
$router->group(['prefix'=>'user/general/group'], function() use($router){
   $router->get('/list', 'groupController@list');
   $router->get('/create', 'groupController@create');
   $router->post('/create', 'groupController@create_submit');
   $router->get('/edit/{id}', 'groupController@edit');
   $router->post('/edit/{id}', 'groupController@edit_submit');
   $router->get('/delete/{id}', 'groupController@delete');
});

//Thêm sửa xóa nhóm sản phẩm con
//role pm pa05
$router->group(['prefix'=>'user/general/sub_group'], function() use($router){
   $router->get('/list/{general_group_id}', 'subgroupController@list');
   $router->get('/create/{general_group_id}', 'subgroupController@create');
   $router->post('/create/{general_group_id}', 'subgroupController@create_submit');
   $router->get('/edit/{id}', 'subgroupController@edit');
   $router->post('/edit/{id}', 'subgroupController@edit_submit');
   $router->get('/delete/{id}', 'subgroupController@delete');
});

//Thêm sửa xóasản phẩm
//role pm pa05
$router->group(['prefix'=>'user/general/product'], function() use($router){
   $router->get('/list/', 'productController@list');
   $router->post('/filter/', 'productController@filter');
   $router->get('/view/{id}', 'productController@view');
   $router->get('/create/{general_sub_group_id}', 'productController@create');
   $router->post('/create/{general_sub_group_id}', 'productController@create_submit');
   $router->get('/edit/{id}', 'productController@edit');
   $router->post('/edit/{id}', 'productController@edit_submit');
   $router->get('/delete/{id}', 'productController@delete');

   $router->get('/price_create/{general_product_id}', 'productController@price_create');
   $router->post('/price_create/{general_product_id}', 'productController@price_create_submit');
   $router->get('/price_edit/{id}', 'productController@price_edit');
   $router->post('/price_edit/{id}', 'productController@price_edit_submit');
   $router->get('/price_delete/{id}', 'productController@price_delete');
});

//Thêm sửa xóa bộ lọc sản phẩm
//role pm pa05
$router->group(['prefix'=>'user/general/filter'], function() use($router){
   $router->get('/list', 'filterController@list');
   $router->post('/list', 'filterController@list_submit');
   $router->get('/create/{general_sub_group_id}', 'filterController@create');
   $router->post('/create/{general_sub_group_id}', 'filterController@create_submit');
   $router->get('/edit/{id}', 'filterController@edit');
   $router->post('/edit/{id}', 'filterController@edit_submit');
   $router->get('/delete/{id}', 'filterController@delete');
});

//Thêm sửa xóa chi tiết bộ lọc sản phẩm
//role pm pa05
$router->group(['prefix'=>'user/general/filter_detail'], function() use($router){
   $router->get('/create/{filter_id}/{content}', 'filterdetailController@create');
   $router->get('/select_product/{id}', 'filterdetailController@select_product');
   $router->post('/select_product/{id}', 'filterdetailController@select_product_submit');
   $router->get('/delete/{id}', 'filterdetailController@delete');
});

//Thêm sửa xóa thành viên tham gia pa05
//role pm pa05
$router->group(['prefix'=>'user/pa05/member'], function() use($router){
   $router->get('/list', 'pa05memberController@list');
   $router->get('/create', 'pa05memberController@create');
   $router->post('/create', 'pa05memberController@create_submit');
   $router->get('/edit/{id}', 'pa05memberController@edit');
   $router->post('/edit/{id}', 'pa05memberController@edit_submit');
   $router->get('/remove/{id}', 'pa05memberController@remove');
});

//Thêm sửa xóa danh mục dùng chung
//role pm pa05
$router->group(['prefix'=>'user/pa05/category'], function() use($router){
   $router->get('/list', 'pa05categoryController@list');
   $router->get('/create/{content}', 'pa05categoryController@create');
   $router->get('/edit/{id}/{content}', 'pa05categoryController@edit');
   $router->get('/delete/{id}', 'pa05categoryController@delete');
   $router->get('/generate/{id}', 'pa05categoryController@generate');
   $router->post('/generate/{id}', 'pa05categoryController@generate_submit');
});

//Thêm sửa xóa chi tiết danh mục dùng chung
//role pm pa05
$router->group(['prefix'=>'user/pa05/category_detail'], function() use($router){
   $router->get('/list/{category_id}', 'pa05categorydetailController@list');
   $router->get('/create/{category_id}', 'pa05categorydetailController@create');
   $router->post('/create/{category_id}', 'pa05categorydetailController@create_submit');
   $router->get('/edit/{id}', 'pa05categorydetailController@edit');
   $router->post('/edit/{id}', 'pa05categorydetailController@edit_submit');
   $router->get('/view/{id}', 'pa05categorydetailController@view');
   $router->get('/delete/{id}', 'pa05categorydetailController@delete');

   $router->get('/price_list/{category_detail_id}', 'pa05categorydetailController@price_list');
   $router->get('/price_create/{category_detail_id}', 'pa05categorydetailController@price_create');
   $router->post('/price_create/{category_detail_id}', 'pa05categorydetailController@price_create_submit');
   $router->get('/price_reset/{category_detail_id}', 'pa05categorydetailController@price_reset');
   $router->get('/price_edit/{id}', 'pa05categorydetailController@price_edit');
   $router->post('/price_edit/{id}', 'pa05categorydetailController@price_edit_submit');
   $router->get('/price_delete/{id}', 'pa05categorydetailController@price_delete');
});

//Thêm sửa xóa region 
//role pm pa05
$router->group(['prefix'=>'user/pa05/region'], function() use($router){
   $router->get('/list', 'pa05regionController@list');
   $router->get('/create', 'pa05regionController@create');
   $router->post('/create', 'pa05regionController@create_submit');
   $router->get('/edit/{id}', 'pa05regionController@edit');
   $router->post('/edit/{id}', 'pa05regionController@edit_submit');
   $router->get('/delete/{id}', 'pa05regionController@delete');
});

//Thêm sửa xóa pa05_year 
//role pm pa05
$router->group(['prefix'=>'user/pa05/year'], function() use($router){
   $router->get('/list/{pa05_region_id}', 'pa05yearController@list');
   $router->get('/create/{pa05_region_id}', 'pa05yearController@create');
   $router->post('/create/{pa05_region_id}', 'pa05yearController@create_submit');
   $router->get('/lock/{id}', 'pa05yearController@lock');
   $router->get('/unlock/{id}', 'pa05yearController@unlock');
   $router->get('/edit/{id}', 'pa05yearController@edit');
   $router->post('/edit/{id}', 'pa05yearController@edit_submit');
   $router->get('/delete/{id}', 'pa05yearController@delete');
});

//Thêm sửa xóa pa05_year_detail
//role pm pa05
$router->group(['prefix'=>'user/pa05/year_detail'], function() use($router){
   $router->get('/list/{pa05_year_id}', 'pa05yeardetailController@list');
   $router->get('/create/{pa05_year_id}', 'pa05yeardetailController@create');
   $router->post('/create/{pa05_year_id}', 'pa05yeardetailController@create_submit');
   $router->post('/create_step2/{pa05_year_id}', 'pa05yeardetailController@create_step2_submit');
   $router->get('/product_info/{product_id}', 'pa05yeardetailController@product_info');

   $router->post('/question_form', 'pa05yeardetailController@question_form');

   $router->get('/edit/{id}', 'pa05yeardetailController@edit');
   $router->post('/edit/{id}', 'pa05yeardetailController@edit_submit');
   $router->get('/view/{id}', 'pa05yeardetailController@view');
   $router->get('/heading_create/{id}', 'pa05yeardetailController@heading_create');
   $router->post('/heading_create/{id}', 'pa05yeardetailController@heading_create_submit');
   $router->get('/heading_edit/{id}', 'pa05yeardetailController@heading_edit');
   $router->post('/heading_edit/{id}', 'pa05yeardetailController@heading_edit_submit');
   $router->get('/order_up/{id}', 'pa05yeardetailController@order_up');
   $router->get('/order_down/{id}', 'pa05yeardetailController@order_down');
   $router->get('/delete/{id}', 'pa05yeardetailController@delete');
   $router->get('/save_to_excel/{id}', 'pa05yeardetailController@save_to_excel');
});


//Thêm sửa xóa thành viên tham gia contract
$router->group(['prefix'=>'user/contract/member'], function() use($router){
   $router->get('/list', 'contractmemberController@list');
   $router->get('/create', 'contractmemberController@create');
   $router->post('/create', 'contractmemberController@create_submit');
   $router->get('/edit/{id}', 'contractmemberController@edit');
   $router->post('/edit/{id}', 'contractmemberController@edit_submit');
   $router->get('/remove/{id}', 'contractmemberController@remove');
});

//Thêm sửa xóa contract
$router->group(['prefix'=>'user/contract/list'], function() use($router){
   $router->get('/list', 'contractlistController@list');
   $router->post('/list', 'contractlistController@list_submit');
   $router->get('/create', 'contractlistController@create');
   $router->post('/create', 'contractlistController@create_submit');
   $router->get('/edit/{id}', 'contractlistController@edit');
   $router->post('/edit/{id}', 'contractlistController@edit_submit');
   $router->get('/delete/{id}', 'contractlistController@delete');
   $router->get('/lock/{id}', 'contractlistController@lock');
   $router->get('/unlock/{id}', 'contractlistController@unlock');
   $router->get('/detail/{id}/{tab}', 'contractlistController@detail');
   $router->post('/detail/{id}', 'contractlistController@detail_submit');
   $router->get('/reset_year/{id}', 'contractlistController@reset_year');
   $router->post('/reset_year/{id}', 'contractlistController@reset_year_submit');

   $router->get('/note/{id}', 'contractlistController@note');
   $router->post('/note/{id}', 'contractlistController@note_submit');
});


//Thêm sửa xóa nhắc gia hạn
$router->group(['prefix'=>'user/contract/expiration'], function() use($router){
   $router->get('/list', 'contractexpirationController@list');
   $router->post('/list', 'contractexpirationController@list_submit');
});

