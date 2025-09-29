<?php

namespace App\Listeners;

use App\Charity\Notfications\SmsService;
use App\Charity\Notfications\WhatsappService;
use App\Charity\Settings\SettingSingleton;
use App\Events\OrderConfirmationEvent;
use App\Mail\OrderConfirm;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderConfirmationEvent $event): void
    {
        $order = $event->order;
        $settings = SettingSingleton::getInstance();
        $mobile = $order->donor?->account?->mobile;

        if ($settings->getOrderNotficationData('email_confirm_status') &&  $email = $order->donor?->account?->email) {
            $subject = $settings->getOrderNotficationData('email_confirm_subject');
            $message = $settings->modifyMessage($settings->getOrderNotficationData('email_confirm_message'), $order);
            try {
                $mail =  Mail::to($email)->send(new OrderConfirm($subject, $message, $order));
              }
              catch(Exception $e) {
              }
            // To Do run queue
        }

        if ($settings->getOrderNotficationData('whatsapp_confirm_status') &&  $mobile) {
            $parameters = [
                ["name" => "name", "value" => $order->donor->full_name],
                ["name" => "order", "value" => $order->identifier],
                ["name" => "amount", "value" => $order->total],
                ["name" => "project", "value" => implode(', ', @$order->details?->pluck('item_name')->toArray() ?? [])],
                ["name" => "link", "value" => route('site.invoices', $order->id)]
            ];
            // $whatsapp = dispatch(new WhatsappService($mobile, $parameters, $settings->getExternalConnectionData('whatsapp_broadcast_name'), $settings->getOrderNotficationData('whatsapp_confirm_template')));
            $whatsapp = new WhatsappService($mobile, $parameters, $settings->getExternalConnectionData('whatsapp_broadcast_name'), $settings->getOrderNotficationData('whatsapp_confirm_template'));
            $whatsapp = $whatsapp->send();
        }

        if ($settings->getOrderNotficationData('sms_confirm_status') &&  $mobile) {
                $message = $settings->modifyMessage($settings->getOrderNotficationData('sms_confirm_message'), $order);
                $sms = new SmsService($mobile, $message);
                $sms = $sms->send();
        }
    }
}
