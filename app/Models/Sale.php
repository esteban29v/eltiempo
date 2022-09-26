<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sale_amount', 'sale_status_id'];

    public function items() {

        return $this->hasMany(SaleItem::class);
    }

    public function status() {
        
        return $this->hasOne(SaleStatus::class, 'id', 'sale_status_id');
    }

    public function updateSaleAmount() {

        if($this->status->status_name == 'pending') {

            $this->sale_amount = $this->items->sum('subtotal');
            $this->save();
        }
        
    }
}
