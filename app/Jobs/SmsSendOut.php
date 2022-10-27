<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Gr8Shivam\SmsApi\Notifications\SmsApiMessage;

class SmsSendOut implements ShouldQueue
{
    use Dispatchable; 
    use InteractsWithQueue; 
    use Queueable;
    use SerializesModels;

    private $smsDetail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($smsDetail)
    {
        $this->smsDetail = $smsDetail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // SmsApi::sendMessage($this->smsDetail['phone'],$this->smsDetail['msg']);
        // smsapi($this->smsDetail['phone'], $this->smsDetail['msg'],json_encode($this->smsDetail));
        smsapi()->sendMessage($this->smsDetail['phone'], $this->smsDetail['msg'],$this->smsDetail);
        return true;
    }
}
