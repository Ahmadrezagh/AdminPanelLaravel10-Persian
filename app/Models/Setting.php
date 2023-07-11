<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->belongsToMany(SettingGroup::class);
    }

    public static function getValue($name)
    {
        return self::where('name',$name)->pluck('value')->first();
    }
}
