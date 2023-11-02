<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController; //Includem controllerul UsersController
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\Admin\PostController; //Includem controllerul PostController

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
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::get('/admin/users', [UsersController::class, 'showUsers'])->middleware(['auth'])->name('users');

//Grupare rute după prefix și middleware
// Route::prefix('admin')->middleware('onlyAdmin')->group(function() {
//     Route::get('/users', 'App\Http\Controllers\Admin\UsersController@showUsers')->name('users');
//     Route::get('/new-user-form', 'App\Http\Controllers\Admin\UsersController@newUserForm')->name('new-user-form');
//     Route::post('/create-new-user', 'App\Http\Controllers\Admin\UsersController@createNewUser')->name('create-new-user');
// });

// <<Grupare rute după prefix, middleware și controller ->aici începe
Route::controller(UsersController::class)->prefix('admin')->middleware('onlyAdmin')->group(function() {
    Route::get('/users', 'showUsers')->name('users');
    Route::get('/new-user-form', 'newUserForm')->name('new-user-form');
    Route::post('/create-new-user', 'createNewUser')->name('create-new-user');
    Route::get('/edit-user-form/{userId}', 'editUserForm')->name('edit-user-form');
    Route::put('/update-user/{userId}', 'updateUser')->name('update-user');
    Route::delete('/delete-user/{userId}', 'deleteUser')->name('delete-user');
});

Route::controller(UserProfileController::class)->prefix('admin')->middleware('auth', 'verified')->group(function() {
    Route::get('/edit-user-profile-form', 'showUserProfileForm')->name('edit-user-profile-form');
    Route::put('/update-user-profile', 'updateUserProfile')->name('update-user-profile');
    Route::put('/update-password', 'updatePassword')->name('update-password');
});

Route::controller(CategoryController::class)->prefix('admin')->middleware('auth', 'verified')->group(function() {
    Route::get('/categories', 'showCategories')->name('admin.categories');
    Route::get('/new-category-form', 'newCategoryForm')->name('admin.new-category-form');
    Route::post('/create-new-category', 'createNewCategory')->name('admin.create-new-category');
    Route::get('/edit-category-form/{categoryId}', 'editCategoryForm')->name('admin.edit-category-form');
    Route::put('/update-category/{categoryId}', 'updateCategory')->name('admin.update-category');
    Route::delete('/delete-category/{categoryId}', 'deleteCategory')->name('admin.delete-category');
});
// Grupare rute după prefix, middleware și controller ->aici se termină >>

// <<Grupare rute după prefix, middleware și controller (2) ->aici începe
Route::controller(PostController::class)->prefix('admin')->middleware('auth', 'verified')->group(function() {
    Route::get('/posts', 'showPosts')->name('admin.posts');
    Route::get('/new-post-form', 'newPostForm')->name('admin.new-post-form');
    Route::post('/create-new-post', 'createNewPost')->name('admin.create-new-post');
    Route::get('/edit-post-form/{postId}', 'editPostForm')->name('admin.edit-post-form');
    Route::put('/update-post/{postId}', 'updatePost')->name('admin.update-post');
    Route::get('/change-categories-form/{postId}', 'showChangeCategoriesForm')->name('admin.change-categories-form');
    Route::put('/change-categories/{postId}', 'changeCategories')->name('admin.change-categories');
    Route::delete('/delete-post/{postId}', 'deletePost')->name('admin.delete-post');//Ruta creată acum...
});
// Grupare rute după prefix, middleware și controller (2) ->aici se termină >>

// Rute pt Front-End, Rute standard:
Route::get('/all-categories', [FrontEndController::class, 'showAllCategories'])->name('front.all-categories');
Route::get('/current-category/{category:slug}', [FrontEndController::class, 'showCurrentCategory'])->name('front.current-category');
Route::get('/all-posts', [FrontEndController::class, 'showAllPosts'])->name('front.all-posts');
Route::get('/current-post/{post:slug}', [FrontEndController::class, 'showCurrentPost'])->name('front.current-post');


require __DIR__.'/auth.php';
