<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Settings extends Model
{
    static function getSettingValue($name)
    {
        $data = Settings::where('settingname', '=', $name)->first();

        return $data->settingvalue;
    }

    static function getSettingID($name)
    {
        $data = Settings::where('settingname', '=', $name)->first();
        return $data['id'];
    }
}
