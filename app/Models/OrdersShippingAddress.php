<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $address
 * @property string $apartment_number
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $country
 */
class OrdersShippingAddress extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'id',
        'order_id',
    ];

    protected $fillable = [
        'address',
        'apartment_number',
        'city',
        'state',
        'zip',
        'country',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
