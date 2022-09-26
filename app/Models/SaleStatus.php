<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleStatus extends Model
{
    use HasFactory;

    protected $table ='sale_status';

    protected $fillable = ['status_name'];

    public $timestamps = false;
}
