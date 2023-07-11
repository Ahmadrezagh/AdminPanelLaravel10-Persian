<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'english_name',
        'persian_name'
    ];

    public function Roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains($permission) || $this->hasPermissionsThroughRole($permission);
    }

    protected function hasPermissionsThroughRole(Permission $permission)
    {
        foreach ($permission->roles as $role)
        {
            if($this->roles->contains($role)) return true;
        }
        return false;
    }
}
