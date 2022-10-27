<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;

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


Route::get('/test', function ()
{
    $connection = null;
    $default = 'default';
    $redis = app()->make('redis');
    $smsDetail = [
        'phone' => request()->phone,
        'msg' => request()->msg,
        'created' => date('Y-m-d H:i:s')
    ];

    // dd($smsDetail);

    $key = base64_encode($smsDetail['phone'].$smsDetail['created']);
    $redis->set("key1",json_encode($smsDetail));


    dd(Redis::keys('*'));
    dd(\Queue::getRedis()
    ->connection($connection)
    ->zrange('queues:'.$default.':delayed', 0, -1));
    return $redis->get("key1");
});

Route::get('/get-pending-job', function ()
{
    $connection = null;
    $default = 'default';
    // dd(\Queue::getRedis()
    // ->connection($connection)
    // ->zrange('queues:'.$default.':delayed', 0, -1));
    // dd(\Queue::getRedis());
    $queues = \Queue::getRedis()->zrange('queues:confluence:delayed' ,0, -1);
    dd($queues,'test');
});

Route::get('/get-total-pending-job', function ()
{
    dd(\Queue::size());
});

Route::any('send-sms',[SmsController::class,'sendSms']);