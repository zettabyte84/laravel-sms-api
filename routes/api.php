<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SmsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/receive_sms', function (Request $request) {
    // dd($request->all());
    Log::info(json_encode($request->all()));
    return true;
});

Route::post('send-sms',[SmsController::class,'sendSms']);
Route::get('consume-one-sms',[SmsController::class,'consumeOneSms']);
Route::get('get-total-pending-job',[SmsController::class,'countJobInQueue']);