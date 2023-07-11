<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'type_id',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function isSuperAdmin()
    {
        return ($this->type_id == 1);
    }
    //  Admin
    //  Get Admins
    public function scopeAdmins($query)
    {
        return $query->where('type_id', 2);
    }

    //  Check is admin
    public function isAdmin()
    {
        return ($this->type_id == 2);
    }

    // if user is admin , show admin's role
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }



    //
    //  User
    // Get All users
    public function scopeUsers($query)
    {
        return $query->where('type_id', 3);
    }

    // Check is user
    public function isUser()
    {
        return $this->type_id == 3  ? true : false;
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }

    public function profile()
    {
        return $this->profile ?? '/uploads/profiles/default/user.png';
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(Permission $permission)
    {
        return $this->hasPermissionsThroughRole($permission) || $this->permissions->contains($permission);
    }

    protected function hasPermissionsThroughRole(Permission $permission)
    {
        foreach ($permission->roles as $role)
        {
            if($this->roles->contains($role)) return true;
        }
        return false;
    }

    public function refreshRoles(... $roles)
    {
        $roles = $this->getAllRoles($roles);

        $this->roles()->sync($roles);

        return $this;
    }

    function getAllRoles(array $role)
    {
        return Role::wherein('name' , Arr::flatten($role))->get();
    }

}
