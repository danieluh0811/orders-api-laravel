<?php

namespace App\Financial\Infrastructure\Db\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentEntity extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'external_transaction_id',
        'created',
        'created_by',
        'updated',
        'updated_by',
        'is_deleted'
    ];
}
