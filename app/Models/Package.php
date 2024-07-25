<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $table = "package";
    protected $primaryKey = 'package_id';
    public $timestamps = false;
    public $fillable = ['invoice_id', 'sch_id', 'price', 'delivery_charge'];

    public static function isPackageExist($invoiceId, $shopID){
        $package = self::where(array('invoice_id'=>$invoiceId,'sch_id'=>$shopID))->first();
        if (!empty($package)) {
            return $package;
        }else{
            return false;
        }
    }
}
