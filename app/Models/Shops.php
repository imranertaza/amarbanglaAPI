<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shops extends Model
{
    use HasFactory;
    protected $table = 'shops';
    protected $primaryKey = 'sch_id';

    /**
     * A shop can have many products.
     */
    public function products()
    {
        return $this->hasMany(Products::class, 'sch_id', 'sch_id');
    }
}
