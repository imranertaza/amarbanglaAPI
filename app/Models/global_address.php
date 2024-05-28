<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class global_address extends Model
{
    use HasFactory;
    protected $table = "global_address";
    protected $primaryKey = 'global_address_id';
}
