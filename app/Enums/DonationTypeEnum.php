<?php

namespace App\Enums;
 
class DonationTypeEnum extends Enum
{


    public const DONATESHARES  = 'share';
    public const FIXEDVALUE = 'fixed';
    public const OPENDONATION = 'open';
    public const DENOMINATION = 'unit';
}
