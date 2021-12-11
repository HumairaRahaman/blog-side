<?php

use Illuminate\Support\Facades\Route;
use App\Tag;
use App\user;
use App\blog;
use App\Category;
use App\Role;

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

Route::get('/userRole', function (){
    $role = Role::find(1);
    foreach ($role->users as $user){
        echo "The user Role is ".$user->name;
    }
});


Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');
//Frontend
Route::get('/', 'FrontendController@index');

Route::get('/blog/{url}', 'FrontendController@blogDetails');


Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/contact', function () {
    return view('frontend.contact');
});



//Backend;
//}

Route::group(['middleware' => 'auth'], function () {


    //User Dashboard
    Route::get('/user/dashboard', 'BackendController@userDashboard');
    Route::get('/user/createBlog', 'BackendController@createBlog');
    Route::post('/user/create', 'BlogController@create');


    Route::group(['middleware' => 'checkrole'], function () {

        Route::get('/dashbord', function () {
            return view('backend.dashbord');
        });
        //category curd
        Route::get('/categories', 'CategoryController@index');
        Route::post('/addCategory', 'CategoryController@create');
        Route::post('/getAllCategories', 'CategoryController@getAllCategories');
        Route::get('/getCategory/{id}', 'CategoryController@getCategory');
        Route::post('/updateCategory', 'CategoryController@updateCategory');
        Route::get('/deleteCategory/{id}', 'CategoryController@deleteCategory');

        //Tags Curd
        Route::get('/tags', 'TagController@index');
        Route::post('/addTag', 'TagController@create');
        Route::post('/getAllTags', 'TagController@getAllTags');
        Route::get('/getTag/{id}', 'TagController@getTag');
        Route::post('/updateTag', 'TagController@updateTag');
        Route::get('/deleteTag/{id}', 'TagController@deleteTag');

        //Blog curd
        Route::get('/blogs', 'BlogController@index');
        Route::get('/createBlog', 'BlogController@createBlogView');
        Route::post('/blogCreate', 'BlogController@create');
        Route::post('/getAllBlogs', 'BlogController@getAllBlogs');

        //edit Blog
        Route::get('/editBlog/{id}', 'BlogController@editBlogView');
        Route::post('/blogUpdate', 'BlogController@update');
//    Route::get('/deleteblog/{id}', 'BlogController@deleteBlog');
        Route::get('/deleteBlog/{id}', 'BlogController@deleteBlog');

    });
});


