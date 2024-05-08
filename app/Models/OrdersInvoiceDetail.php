<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $tax_id
 */
class OrdersInvoiceDetail extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'tax_id',
    ];

    protected $hidden = [
        'id',
        'order_id',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
