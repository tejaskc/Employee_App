<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api']], function () {
    /** Routes for employee operation for api test in postman*/
    Route::get('/employee/summary', [EmployeeController::class, 'get']);
    Route::post('/employee/create', [EmployeeController::class, 'create']);
    Route::post('/employee/update', [EmployeeController::class, 'update']);
    Route::get('/employee/delete/{id}', [EmployeeController::class, 'delete']);
});
