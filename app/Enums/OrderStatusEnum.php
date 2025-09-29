<?php

namespace App\Enums;
use Html;

class OrderStatusEnum extends Enum
{


    public const WAITING  = 'waiting';
    public const NOT_CONFIRMED = 'not confirmed';
    public const CONFIRMED = 'confirmed';
    public const CANCELED = 'Canceled';


    public function toHtml($value)
    {
        
        switch ($value) {
            case self::WAITING:
                return '<i class="bx bxs-check-square"></i>';

            case self::NOT_CONFIRMED:
                return '<i class="bx bxs-check-square"></i>';

            case self::CONFIRMED:
                return '<i class="bx bxs-check-square"></i>';

            case self::CANCELED:
                return '<i class="bx bxs-check-square"></i>';

            default:
                return '';
        }
    }
}
