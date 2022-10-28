<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\Redis as RedisNow;

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
    // $redis = new Redis;
    // $redis->connect('localhost', 6379);
    // // $redis->scan('laravel_database_queues', 0);
    // // dd($redis);
    // $connection = null;
    // $default = 'default';
    // // dd(\Queue::getRedis()
    // // ->connection($connection)
    // // ->zrange('queues:'.$default.':delayed', 0, -1));
    // // dd(\Queue::getRedis());
    // // $queues = \Queue::getRedis()->zrange('queues:confluence:delayed' ,0, -1);

    // // $getQueue = \Queue::getRedis()->connection($connection)->keys('*');
    // // foreach ($getQueue as $key => $value) {
    // //     echo $key . '|' . $value;
    // //     print_r(\Queue::getRedis()->connection($connection)->keys($value));
    // //     echo '<br>';
    // // }

    // dd(\Queue::getRedis()->connection($connection)->keys('*'),
    // RedisNow::lrange('queues:laravel_database_queues:default', 0, -1));
    // $queues = Queue::getRedis()->zrange('laravel_database_queues',0,1000);
    // dd($queues);
    // foreach ($queues as $job) {
    //     $tmpdata = json_decode($job);
    //     $command = $tmpdata->data->command;
    //     echo $tmpdata;
    // }

    // dd($queues,'test',\Queue::getRedis()
    //     ->connection($connection)
    //     ->zrange('laravel_database_queues:'.$default.':delayed', 0, -1),
    //     // $redis->connect($connection)->keys('laravel_database_queues:default')
    //     $redis->keys('laravel_database_queues:default'),
    //     \Queue::getRedis()->connection($connection)->keys('*'),
    //     RedisNow::lrange('queues:laravel_database_queues:default', 0, -1)
    // );

    $connection = null;
    $default = 'default';

    //For the delayed jobs
    var_dump( Queue::getRedis()->connection($connection)->keys('*')->job());

    //For the reserved jobs
    var_dump( Queue::getRedis()->connection($connection)->zrange('laravel_database_queues:'.$default.':reserved' ,0, -1) );
});

// Route::get('/get-redis-test', function ()
// {
//     $redis = new Redis;
//     $redis->connect('localhost', 6379);
//     // Get the stored data and print it 
//    $arList = $redis->lrange("laravel_database_queues:default", 0 ,5); 
//    foreach ($arList as $key => $value) {
//     // $command = unserialize(json_decode($value)->data->command);
//     // $command = unserialize(json_decode($value,true));
//     $main1 = json_decode($value,true);
//     $command = $main1['data']['command'];
//     // dd();
//     // dd(unserialize(json_decode($command)));
//     $command2 = unserialize($command);
//     // dd($command2[0]->smsDeatil);
//     var_dump($command2['smsDetail']);
//     dd($command);
//     foreach ($command as $key => $value2) {
//         print_r($key);
//         print_r($value2);
//     }
//     echo "<br>";
//    }
// //    echo "Stored string in redis:: "; 
// //    print_r($arList); 
// });

Route::post('send-sms',[SmsController::class,'sendSms']);