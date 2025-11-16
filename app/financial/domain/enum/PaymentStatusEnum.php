<?php

namespace App\Financial\Domain\Enum;

enum PaymentStatusEnum: string
{
    case SUCCESS = 'success';
    case FAILED  = 'failed';
}
