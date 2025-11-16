<?php

namespace App\Financial\Domain\Enum;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PAID    = 'paid';
    case FAILED  = 'failed';
}
