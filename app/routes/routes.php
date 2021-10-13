<?php

use Teknasyon\app\controller\AuthController;
Use Teknasyon\Config\Route;



Route::post('/register',['Auth'=>'not_login'],'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('/users',['Auth'=>'check','Permission'=>'check.users_show'], 'UserController@index');
Route::post('/users/{id}',['Auth'=>'check','Permission'=>'check.user_update'], 'UserController@update');
Route::delete('/users/{id}', ['Auth'=>'check','Permission'=>'check.user_delete'], 'UserController@delete');
Route::get('/users/{id}',['Auth'=>'check','Permission'=>'check.users_show'], 'UserController@show');
Route::get('/users/requestDelete',['Auth'=>'check','Permission'=>'check.request_delete_account'], 'UserController@requestDelete');

Route::get('/categories',['Auth'=>'check','Permission'=>'check.category_show'], 'CategoryController@index');
Route::post('/categories/{id}',['Auth'=>'check', 'Permission'=>'check.category_update'],'CategoryController@update');
Route::post('/categories',['Auth'=>'check','Permission'=>'check.category_create'], 'CategoryController@create');
Route::delete('/categories/{id}', ['Auth'=>'check','Permission'=>'check.category_delete'], 'CategoryController@delete');
Route::get('/categories/{id}/news',['Auth'=>'check','Permission'=>'check.category_show'], 'CategoryController@news');


Route::post('/news/{id}',['Auth'=>'check', 'Permission'=>'check.news_update'],'NewsController@update');
Route::get('/news/{id}/comments',['Auth'=>'check', 'Permission'=>'check.news_comment'],'NewsController@comments');
Route::post('/news',['Auth'=>'check','Permission'=>'check.news_create'], 'NewsController@create');
Route::get('/news/{id}',['Auth'=>'check','Permission'=>'check.news_show'], 'NewsController@show');
Route::delete('/news/{id}', ['Auth'=>'check','Permission'=>'check.news_delete'], 'NewsController@delete');


Route::post('/comments', 'CommentController@create');
Route::delete('/comments/{id}', ['Auth'=>'check','Permission'=>'check.comment_delete'], 'CommentController@delete');
Route::get('/logs',['Auth'=>'check','Permission'=>'check.show_log'], 'LogController@log');