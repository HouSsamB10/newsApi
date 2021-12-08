<?php

use Facade\FlareClient\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
for test 
Route::get('/users', function () {
    $user = \App\Models\User::paginate();
    return new \App\Http\Resources\UsersResource($user);
});
*/

/* user route */
Route::get('users', 'App\Http\Controllers\Api\UserController@index');
Route::get('users/{id}', 'App\Http\Controllers\Api\UserController@show');
Route::get('posts/user/{id}', 'App\Http\Controllers\Api\UserController@posts');
Route::get('comments/user/{id}', 'App\Http\Controllers\Api\UserController@comments');
/* end  user route */

/* category route */
Route::get('categories', 'App\Http\Controllers\Api\CategoryController@index');
Route::get('posts/category/{id}', 'App\Http\Controllers\Api\CategoryController@posts');
/* end  category route */

/* post route */
Route::get('posts', 'App\Http\Controllers\Api\PostController@index');
Route::get('posts/{id}', 'App\Http\Controllers\Api\PostController@show');
Route::get('comments/posts/{id}', 'App\Http\Controllers\Api\PostController@comments');
/* end  post route */


/* make posts requist */ 
Route::post('register', 'App\Http\Controllers\Api\UserController@store');
Route::post('token', 'App\Http\Controllers\Api\UserController@getToken');


/* make defualt
Route::middleware('auth:sanctum')->group(function(){

Route::post('update-user/{id}', 'App\Http\Controllers\Api\UserController@update' );

});
*/



Route::group(['middleware' => ['auth:sanctum']],function(){
/* route post   posts */ 
    Route::post('update-user/{id}', 'App\Http\Controllers\Api\UserController@update' );
    Route::post('posts', 'App\Http\Controllers\Api\PostController@store');
    Route::post('posts/{id}', 'App\Http\Controllers\Api\PostController@update');
    Route::delete('posts/{id}', 'App\Http\Controllers\Api\PostController@destroy');

/* route post   comments */ 
    Route::post('comments/posts/{id}','App\Http\Controllers\Api\CommentController@store' );
});
