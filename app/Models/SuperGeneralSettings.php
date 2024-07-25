<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperGeneralSettings extends Model
{
    use HasFactory;
    protected $table = "gen_settings_super";

    public static function getSettingItem($item, $shopID){
        return self::select('value')->where("label", $item)->first();
    }
}
