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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/* Batch Route
 * CRUD Route
*/
Route::get('/b', 'BatchController@index');
Route::get('/b/create', 'BatchController@create')->name('create_batch');
Route::post('/b', 'BatchController@store');


Route::get('/b/grabBatch1', 'BatchController@grabBatch1')->name('batch_data1');
Route::get('/b/grabBatch2', 'BatchController@grabBatch2')->name('batch_data2');

/* VueJs Route <search-batches> */
Route::get('getBatches1', 'BatchController@getBatches1');
Route::get('getBatches2', 'BatchController@getBatches2');
Route::get('getRecords', 'BatchController@getRecords');
Route::get('getRecordMonths', 'BatchController@getRecordMonths');

/* Course Route */
Route::get('/c', 'CourseController@index');
Route::get('/c/create', 'CourseController@create')->name('create_course');
Route::post('/c', 'CourseController@store');

Route::get('/c/grabCourse', 'CourseController@getCourse')->name('course_data');;

/* Student Route
 * CRUD Route
*/
Route::get('/s', 'StudentController@index');
Route::get('/s/record/create', 'StudentController@create')->name('create_record');
Route::post('/s', 'StudentController@store');

/* Search Route */
Route::get('/s/search', 'StudentController@searchRecord')->name('search_record');
Route::get('/s/record', 'StudentController@dataRecord');
Route::get('/s/record/import', 'StudentController@importRecord')->name('import_record');
Route::get('/s/record/list', 'StudentController@createList')->name('create_list');
Route::get('/s/record/photo', 'StudentController@createPhoto')->name('create_photo');

Route::get('/s/record/grabRecord', 'StudentController@grabRecord')->name('record_data');


Route::get('/home', 'HomeController@index')->name('home');
