<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $table = 'sales_item';

    protected $fillable = [
        'sale_id',
        'product_id',
        'price_per_unit',
        'product_amount',
        'subtotal',
    ];

    public function sale() {

        return $this->belongsTo(Sale::class);
    }
}
