<?php

namespace App\Enums;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use InvalidArgumentException;

class ShippingStatusEnum extends Enum implements Htmlable
{

    public const PENDING  = 'pending';
    public const PICKING = 'picking';
    public const PICKED = 'picked';
    public const DELIVERING = 'delivering';
    public const DELIVERED = 'delivered';
    public const CANCELED = 'canceled';


    /**
     * @return string
     */
    public function toHtml(): HtmlString
    {
        $labelClass = match ($this->value) {
            self::PENDING => 'label-info',
            self::PICKING => 'label-info',
            self::PICKED => 'label-primary',
            self::DELIVERING => 'label-primary',
            self::DELIVERED => 'label-success',
            self::CANCELED => 'label-danger',
            default => 'label-default',
        };

        return new HtmlString('<span class="' . $labelClass . ' status-label">' . $this->label() . '</span>');
    }

    public static function from(string $value): self
    {
        return self::tryFrom($value) ?? throw new InvalidArgumentException("Invalid shipping status value: $value");
    }

    public static function tryFrom(string $value): ?self
    {
        return match ($value) {
            self::PENDING => self::PENDING,
            self::PICKING => self::PICKING,
            self::PICKED => self::PICKED,
            self::DELIVERING => self::DELIVERING,
            self::DELIVERED => self::DELIVERED,
            self::CANCELED => self::CANCELED,
            default => null,
        };
    }
}
