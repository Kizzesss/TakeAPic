<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
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
use App\Models\Image;

Route::get('/', function () {

    return view('welcome');
});

//Generales
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Usuarios
Route::get('/config', [UserController::class, 'config'])->name('config');
Route::get('/admin', [UserController::class, 'admin'])->name('admin');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::post('/user/update', [UserController::class, 'update'])->name('user.update');
Route::get('/user/image/{filename}', [UserController::class, 'getImage'])->name('user.image');
Route::get('/user/{id}/edit_user', [UserController::class, 'editUser'])->name('user.edit_user');
Route::post('/user/{id}/updateUser', [UserController::class, 'updateUser'])->name('user.updateUser');
Route::get('/user/create_user', [UserController::class, 'createUser'])->name('user.create_user');
Route::post('/category/insertUser', [UserController::class, 'insertUser'])->name('user.insertUser');
Route::get('/perfil/{id}', [UserController::class, 'profile'])->name('user.profile');
Route::get('/usuarios/{search?}', [UserController::class, 'index'])->name('user.index');

//Imagenes
Route::get('/subir_imagen', [ImageController::class, 'create'])->name('image.create');
Route::post('/image/save', [ImageController::class, 'save'])->name('image.save');
Route::get('/image/file/{filename}', [ImageController::class, 'getImage'])->name('image.file');
Route::get('/image/{id}', [ImageController::class, 'detail'])->name('image.detail');
Route::get('/image/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
Route::get('/image/edit/{id}', [ImageController::class, 'edit'])->name('image.edit');
Route::post('/image/update', [ImageController::class, 'update'])->name('image.update');

//Categorias
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
Route::get('/category/{id}/edit_category', [CategoryController::class, 'editCategory'])->name('category.edit_category');
Route::post('/category/{id}/updateCategory', [CategoryController::class, 'updateCategory'])->name('category.updateCategory');
Route::get('/category/create_category', [CategoryController::class, 'createCategory'])->name('category.create_category');
Route::post('/category/insertCategory', [CategoryController::class, 'insertCategory'])->name('category.insertCategory');

//Comentarios
Route::get('/comment', [CommentController::class, 'comment'])->name('comment');
Route::post('/comment/save', [CommentController::class, 'save'])->name('comment.save');
Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

//Likes
Route::get('/like/{image_id}', [LikeController::class, 'like'])->name('like.save');
Route::get('/dislike/{image_id}', [LikeController::class, 'dislike'])->name('like.delete');







