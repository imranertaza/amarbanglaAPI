<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $primaryKey = 'prod_id';


    public static function getShopIDByProductID($product_id){
        $shop = self::select("sch_id")->where("prod_id", $product_id)->first();
        return $shop->sch_id;
    }
}
