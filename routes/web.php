<?php

use App\Http\Controllers\EmployeeController;
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
Route::group(['middleware' => ['web']], function () {
    /** Routes for employee operation*/
    Route::get('/employee/summary', [EmployeeController::class, 'get']);
    Route::post('/employee/create', [EmployeeController::class, 'create']);
    Route::post('/employee/update', [EmployeeController::class, 'update']);
    Route::get('/employee/delete/{id}', [EmployeeController::class, 'delete']);
});
