<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeatures extends Model
{
    use HasFactory;
    protected $table = 'product_features';
    protected $primaryKey = 'feature_id';

    public function product()
    {
        return $this->belongsTo(Products::class, 'prod_id', 'prod_id');
    }
}
