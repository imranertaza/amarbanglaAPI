<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    use HasFactory;
    protected $table = "gen_settings";

    public static function getSettingItem($item, $shopID){
        return self::select('value')->where("sch_id", $shopID)->where("label", $item)->first();
    }
}
