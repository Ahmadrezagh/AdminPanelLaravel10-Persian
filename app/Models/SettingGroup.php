<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    use HasFactory;

    public static function findByNameOrFail($name)
    {
        return SettingGroup::query()->where('name','=',$name)->firstOrFail();
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
