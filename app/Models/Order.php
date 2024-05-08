<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read OrdersCustomerDetail $customerDetail
 * @property-read OrdersInvoiceDetail $invoiceDetail
 * @property-read OrdersShippingAddress $shippingAddress
 * @property-read OrdersProduct[] $products
 */
class Order extends Model {
    use HasFactory, SoftDeletes;

    public static function boot() {
        parent::boot();
        static::creating(function (Order $order) {
            $order->uuid = \Illuminate\Support\Str::uuid();
        });
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'status',
    ];

    protected $with = ['customerDetail', 'invoiceDetail', 'shippingAddress', 'products'];

    public function customerDetail(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(OrdersCustomerDetail::class);
    }

    public function invoiceDetail(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(OrdersInvoiceDetail::class);
    }

    public function shippingAddress(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(OrdersShippingAddress::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(OrdersProduct::class);
    }
}
