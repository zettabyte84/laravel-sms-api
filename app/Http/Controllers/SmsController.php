<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SmsSendOut;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Send SMS to queue.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendSms(Request $request)
    {
        $smsDetail = [
            'phone' => $request->phone,
            'msg' => $request->msg,
        ];
        // smsapi()->sendMessage($request->phone, $request->msg,$smsDetail);
        SmsSendOut::dispatch($smsDetail);
        return "good";
    }

    /**
     * Consume 1 SMS FIFO
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function consumeOneSms(Request $request)
    {
        \Artisan::call('queue:work --once');
        return true;
    }

    /**
     * Count Job in Queue
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function countJobInQueue()
    {
        return \Queue::size();
    }
}
