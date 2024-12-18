<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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
    ];

    
    //User Roles Relationship
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    //User Permissions Relationship
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }


    //Roles and Permissions
    public function assignRole($roleName)
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $this->roles()->attach($role);
        } else {
            throw new \Exception("Role '{$roleName}' does not exist.");
        }
    }

    public function hasPermission($permissionName)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permissionName)) {
                return true;
            }
        }
        return false;
    }

    public function hasUserPermission($permissionName)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->name == $permissionName) {
                return true;
            }
        }
        return false;
    }
    //End Roles and Permissions
}
