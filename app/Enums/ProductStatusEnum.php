<?php

namespace App\Enums;


class ProductStatusEnum extends Enum
{


    public const PENDING        = 'pending';
    public const PUBLISHED      = 'published';
    public const UNPUBLISHED    = 'unpublished';
    // public const APPROVED       = 'approved';
    // public const DRAFT          = 'draft';
    // public const REVIEW         = 'review';
    // public const REJECTED       = 'rejected';




    /**
     * @return string
     */
    // public function toHtml() 
    // {
    //     switch ($this->value) {
    //         case self::DRAFT:
    //             return Html::tag('span', self::DRAFT()->label(), ['class' => 'label-info status-label'])
    //                 ->toHtml();
    //         case self::PENDING:
    //             return Html::tag('span', self::PENDING()->label(), ['class' => 'label-warning status-label'])
    //                 ->toHtml();
    //         case self::PUBLISHED:
    //             return Html::tag('span', self::PUBLISHED()->label(), ['class' => 'label-success status-label'])
    //                 ->toHtml();
    //         case self::APPROVED:
    //             return Html::tag('span', self::APPROVED()->label(), ['class' => 'label-success status-label'])
    //                 ->toHtml();
    //         case self::REVIEW:
    //             return Html::tag('span', self::REVIEW()->label(), ['class' => 'label-success status-label'])
    //                 ->toHtml();
    //         case self::UNPUBLISHED:
    //             return Html::tag('span', self::UNPUBLISHED()->label(), ['class' => 'label-warning status-label'])
    //                 ->toHtml();
    //         case self::REJECTED:
    //             return Html::tag('span', self::REJECTED()->label(), ['class' => 'label-warning status-label'])
    //                 ->toHtml();
    //         default:
    //             return parent::toHtml();
    //     }
    // }


}
