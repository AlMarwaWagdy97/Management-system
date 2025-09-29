<?php

namespace App\Http\Controllers\Api\Test;

use App\Charity\Notfications\EmailService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Charity\Notfications\SmsService;
use App\Charity\Notfications\WhatsappService;

class NotficationTestController extends Controller
{
    public function whatsapp(Request $request){
        $data = $request->all();
        $parameters = [
            ["name" => "name", "value" => $data['name']],
            ["name" => "order", "value" => $data['order']],
            ["name" => "amount", "value" => $data['amount']],
            ["name" => "placeholder", "value" => $data['placeholder']]
        ];
        $email = new WhatsappService($data['mobile'], $parameters , "birrukum", $data["tamplate"]);
        $email = $email->send();
        return response()->json([
            'data' => $email,
            'message' => 'email Send Successfully',
        ]);
    }


    public function email(Request $request){
        $data = $request->all();
        $email = new EmailService($data['email'], $data['subject'], $data['message']);
        $email = $email->send();
        return response()->json([
            'data' => $email,
            'message' => 'email Send Successfully',
        ]);

    }

    public function sms(Request $request){

        $data = $request->all();

        $sms = new SmsService($data['mobile'], $data['msg']);
        $sms = $sms->send();
        return response()->json($sms);

        // return response()->json([
        //     'data' => $sms,
        //     'message' => 'sms Send Successfully',
        // ]);
    }

}
