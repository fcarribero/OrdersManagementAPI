<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $order_id
 * @property string $description
 * @property string $sku
 * @property float $quantity
 * @property float $price
 * @property float $discount
 * @property float $total
 * @property-read Order $order
 */
class OrdersProduct extends Model {
    use HasFactory;

    public $timestamps = false;

    protected $hidden = [
        'id',
        'order_id',
    ];

    public static function boot() {
        parent::boot();
        static::saving(function (OrdersProduct $model) {
            if ($model->getAttribute('total') === null) $model->total = $model->calculateTotal();
        });
    }

    protected $fillable = [
        'description',
        'sku',
        'quantity',
        'price',
        'discount',
        'total',
    ];

    protected $casts = [
        'quantity' => 'float',
        'price' => 'float',
        'total' => 'float',
        'discount' => 'float',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }

    protected function calculateTotal(): float {
        // Para evitar problemas de precisión, se redondea a 2 decimales
        return round(($this->quantity * $this->price) - $this->discount, 2);
    }
}
