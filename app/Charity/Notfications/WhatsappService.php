<?php

namespace App\Charity\Notfications;

use App\Charity\Settings\SettingSingleton;
use Illuminate\Support\Facades\Http;


class WhatsappService
{

    /**
     * The number to which the whatsapp will be sent .
     * @var string
     */
    protected $mobile;

    /**
     * parameters gives in whatsapp                                                              
     * @var string
     */
    protected $parameters;

    /**
     * broadcast name of whatsapp                                                                   
     * @var string
     */
    protected $broadcast;

    /**
     * template name of whatsapp                                                                  
     * @var string
     */
    protected $template;


    /**
     * Whatsapp constructor.
     *
     * @param string $mobile
     * @param string $msg
     */
    public function __construct($mobile, $parameters, $broadcast, $template)
    {
        $this->mobile = $mobile;
        $this->parameters = $parameters;
        $this->broadcast = $broadcast;
        $this->template = $template;
    }

    /**
     *
     *  send Whatsapp 
     */
    public function send()
    {
        $settings = SettingSingleton::getInstance();
        $gateurl = $settings->getExternalConnectionData('whatsapp_gateurl');
        $accessToken = $settings->getExternalConnectionData('whatsapp_accessToken');
        
        $to = "966" . substr($this->mobile, -9, 9);
        
        $params = '?whatsappNumber=' . urlencode($to); //  Parameters
        $url = $gateurl . $params; // url
        // header  
        $headers = [
            "Accept" => "application/json",
            "Content-Type" => "application/json",
            "Authorization" => "Bearer " . $accessToken,
        ];
        $data = [
            "parameters" => $this->parameters,
            "broadcast_name" => $this->broadcast,
            "template_name" => $this->template,
            
        ];
        $response = Http::withHeaders($headers)->post($url, $data);
        return $response->body();
    }



    /**
     * prepare parameters in whatsapp 
     * @var string
    */
    public function prepareParams($data): array
    {
        $parameters = [
            ["name" => "name", "value" => $data['donor']],
            ["name" => "order", "value" => $data['identifier']],
            ["name" => "amount", "value" => $data['total']],
            ["name" => "substitute_name", "value" => @$data['substitute_name']],
            ["name" => "substitute_start", "value" =>  date('Y/ m/ d | H:i a',  @$data['substitute_start'])],
            ["name" => "identifier", "value" => @$data['identifier']],
            ["name" => "projects", "value" => @$data['project']],
            ["name" => "behafeof", "value" => @$data['behafeof']],
            ["name" => "rate", "value" => @$data['rate']],
        ];

        return $parameters;
    }


    /**
     * get tamplate of whatsapp
     * @var string
    */
    public function getTamplate($type): string
    {
        switch ($type) {
            case 'newOrder':
                return "arrive_order";
            case 'newRequest':
                return "new_request";
            case 'selectRequest':
                return "select_request";
            case 'start_order':
                return "start_order";
            case 'complete_order':
                return "complete_order";
            case 'lateRequest':
                return "late_request";
            case 'cancelRequest':
                return "cancel_request";
            case 'newOffer':
                return "new_offer";
            case 'review':
                return "review";
            case 'notify_order':
                return "notify_order";
            default:
                break;
        }
        return "";
    }

}
