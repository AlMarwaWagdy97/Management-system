<?php

namespace App\Jobs;

use App\Charity\Notfications\EmailService;
use App\Mail\NotifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Charity\Notfications\SmsService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Charity\Notfications\WhatsappService;

class SendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // $response = dispatch(new SendNotifications($data));

    /**
     * data .
     * @var string
     */
    public $data;


    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }


    /**
     * send email
     * @var string
     */
    public function sendMail($email, $subject, $message)
    {
        $email = new EmailService($email, $subject, $message);
        $email = $email->send();
    }

    /**
     * send SMS
     * @var string
    */
    public function sendSMS($mobile, $msg)
    {
        $sms = new SmsService($mobile, $msg);
        $sms = $sms->send();
    }

    /**
     * send Whatsapp
     * @var string
    */
    public function whatsapp($mobile, $parameters, $broadcast, $template)
    {
        $whatsapp = new WhatsappService($mobile, $parameters, $broadcast, $template);
        $whatsapp = $whatsapp->send();
    }  
    
    
    /**
     * update message
     * @var string
    */
    public function getMessage($message, $data): string
    {
        $msg = str_replace('[[name]]', $data['donor'], $message); // replace name string with user name
        @$data['identifier'] ? $msg = str_replace('[[identifier]]', $data['identifier'], $msg) : ""; // replace identifier string with identifier
        @$data['total'] ? $msg = str_replace('[[total]]', $data['total'], $msg) : ""; // replace total string with order total
        @$data['project'] ? $msg = str_replace('[[project]]', $data['project'], $msg) : ""; // replace project string with project name
        @$data['substitute_name'] ? $msg = str_replace('[[substitute_name]]', @$data['substitute_name'], $msg) : " "; // replace substitute name string with substitute name
        @$data['behafeof'] ? $msg = str_replace('[[behafeof]]', @$data['behafeof'], $msg) : " "; // replace substitute name string with substitute name
        @$data['substitute_start'] ? $msg = str_replace('[[substitute_start]]',  date('Y/ m/ d | H:i a', @$data['substitute_start']), $msg) : ""; // replace start date string with start date name
        @$data['rate'] ? $msg = str_replace('[[rate]]', @$data['rate'], $msg) : " "; // replace start date string with start date name
        return $msg;
    }

    
}
