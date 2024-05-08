<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $external_id
 * @property string $name
 * @property string $email
 * @property string $phone
 *
 * @property-read Order $order
 */
class OrdersCustomerDetail extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'external_id',
        'name',
        'email',
        'phone',
    ];

    protected $hidden = [
        'id',
        'order_id',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
