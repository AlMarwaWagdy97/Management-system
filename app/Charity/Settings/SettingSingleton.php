<?php

namespace App\Charity\Settings;

use App\Models\Settings;


class SettingSingleton
{
    private static $instance;
    private $settings;

    private $siteSetting, $colorsSetting, $giftSetting, $loginSetting, $metaSetting, $productSetting;
    private $customCampaignSetting, $externalConnectionSetting, $contactInformationSetting;
    private $orderNotficationSetting, $volunteeringSetting, $badalSetting, $pixelSetting;

    private function __construct()
    {
        // Prevent instantiation
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new SettingSingleton();
            self::$instance->loadSettingDatabase();
        }
        return self::$instance;
    }

    private function loadSettingDatabase()
    {
        // Code to retrieve header and footer content from the database
        // Example:

        $this->settings = Settings::with('values')->get();
        if ($this->settings) {
            $this->siteSetting = (clone $this->settings)->where('key', 'general')->first()?->values;

            $this->metaSetting = (clone $this->settings)->where('key', 'meta')->first()?->values;

            $this->colorsSetting = (clone $this->settings)->where('key', 'color')->first()?->values;

            $this->giftSetting = (clone $this->settings)->where('key', 'gift')->first()?->values;

            $this->loginSetting = (clone $this->settings)->where('key', 'login')->first()?->values;

            $this->productSetting = (clone $this->settings)->where('key', 'product')->first()?->values;

            $this->customCampaignSetting = (clone $this->settings)->where('key', 'custom_campaign')->first()?->values;

            $this->externalConnectionSetting = (clone $this->settings)->where('key', 'external_connection')->first()?->values;

            $this->contactInformationSetting = (clone $this->settings)->where('key', 'contact_information')->first()?->values;

            $this->orderNotficationSetting = (clone $this->settings)->where('key', 'notifications')->first()?->values;

            $this->volunteeringSetting = (clone $this->settings)->where('key', 'volunteering')->first()?->values;

            $this->badalSetting = (clone $this->settings)->where('key', 'badal')->first()?->values;

            $this->pixelSetting = (clone $this->settings)->where('key', 'pixel')->first()?->values;
        }
    }


    public function getSiteSetting()
    {
        return $this->siteSetting;
    }

    public function getColorSetting()
    {
        return $this->colorsSetting;
    }

    public function getGiftSetting()
    {
        return $this->giftSetting;
    }

    public function getLoginSetting()
    {
        return $this->loginSetting;
    }
    public function getMetaSetting()
    {
        return $this->metaSetting;
    }

    public function getProductsSetting()
    {
        return $this->productSetting;
    }

    public function getCustomCampaignSetting()
    {
        return $this->customCampaignSetting;
    }

    public function getExternalConnectionSetting()
    {
        return $this->externalConnectionSetting;
    }

    public function getContactInformationSetting()
    {
        return $this->contactInformationSetting;
    }
    public function getOrderNotficationSetting()
    {
        return $this->orderNotficationSetting;
    }
    public function getVolunteeringSetting()
    {
        return $this->volunteeringSetting;
    }
    public function getBadalSetting()
    {
        return $this->badalSetting;
    }


    public function getItem($val)
    {
        // dd([
        //     'requested_key' => $val,
        //     'site_setting' => $this->siteSetting->toArray() ?? 'No site settings'
        // ]);
        foreach ($this->settings as $setting) {
        if ($setting->key === 'general' && isset($setting->values[$val])) {
            return $setting->values[$val];
         }
            }
                
                $setting = Settings::where('key', 'general')->first();
                if ($setting && isset($setting->values[$val])) {
                    return $setting->values[$val];
                }

                $value = "";
                if (substr($val, -3) == "_en" || substr($val, -2) ==  "_ar") {
                    $val = substr($val, 0, -3) . '_' . app()->getLocale();
                }
                switch ($val) {
                    case 'site_name':
                        $value = $this->siteSetting->where('key', 'site_' . app()->getLocale())->first()?->value;
                        break;
                    case 'logo':
                        $value = $this->siteSetting->where('key', 'logo_' . app()->getLocale())->first()?->value;
                        break;
                    case 'logo_mobile':
                        $value = $this->siteSetting->where('key', 'logo_mobile_' . app()->getLocale())->first()?->value;
                        break;
                    case 'show_fast_donation':
                        $value = $this->siteSetting->where('key', 'show_fast_donation')->first()?->value;
                        break;
                    case 'footer_description':
                        $value = $this->siteSetting->where('key', 'footer_description_' . app()->getLocale())->first()?->value;
                        break;
                    default:
                        if (substr($val, -3) == "_en" || substr($val, -2) ==  "_ar") {
                            $val = substr($val, 0, -3) . '_' . app()->getLocale();
                        }
                        $value = $this->siteSetting->where('key', $val)->first()?->value;
                }
                return $value;
    }


    public function getColor($val)
    {
        $color = $this->colorsSetting?->where('key', $val)->first()?->value;
        if ($color) {
            return array_filter(json_decode($color));
        }
    }

    public function getTheme($val)
    {
        return $this->colorsSetting?->where('key', $val)->first()?->value;
    }

    public function getGift($val)
    {
        return $this->giftSetting->where('key', $val)->first()?->value;
    }

    public function getLoginStatus($val)
    {
        return $this->loginSetting->where('key', $val)->first()?->value;
    }

    public function getProductsData($val)
    {
        return $this->productSetting?->where('key', $val)->first()?->value;
    }

    public function getCustomCampaignData($val)
    {
        return $this->customCampaignSetting->where('key', $val)->first()?->value;
    }

    public function getExternalConnectionData($val)
    {
        return $this->externalConnectionSetting->where('key', $val)->first()?->value;
    }

    public function getContactInformationData($val)
    {
        return $this->contactInformationSetting->where('key', $val)->first()?->value;
    }
    public function getOrderNotficationData($val)
    {
        return $this->orderNotficationSetting->where('key', $val)->first()?->value;
    }
    public function getVolunteeringData($val)
    {
        return $this->volunteeringSetting->where('key', $val)->first()?->value;
    }

    public function getBadalData($val)
    {
        return $this->badalSetting->where('key', $val)->first()?->value;
    }

    public function getData($model, $val)
    {
        return $model->where('key', $val)->first()?->value;
    }


    public function getPixel($val)
    {
        return $this->pixelSetting->where('key', $val)->first()?->value;
    }

    public function modifyMessage($msg, $order)
    {
        $msg = str_replace('[[name]]', @$order->donor->full_name, $msg); // replace name string with user name
        $msg = str_replace('[[identifier]]', $order->identifier, $msg); // // replace name string with user name
        $msg = str_replace('[[total]]', $order->total,  $msg); // replace name string with user name
        $msg = str_replace('[[project]]', implode(', ', @$order->details?->pluck('item_name')->toArray() ?? []), $msg); // replace name string with user name
        $msg = str_replace('[[link]]', route('site.invoices', $order->id), $msg); // replace link string with order invoices
        return $msg;
    }
}
