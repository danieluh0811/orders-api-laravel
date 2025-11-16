<?php

namespace App\Financial\Infrastructure\Db\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderEntity extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false; 

    protected $fillable = [
        'customer_name',
        'total_amount',
        'status',
        'created',
        'created_by',
        'updated',
        'updated_by',
        'is_deleted'
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(PaymentEntity::class, 'order_id', 'order_id');
    }
}
