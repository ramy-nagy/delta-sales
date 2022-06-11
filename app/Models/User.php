<?php

namespace App\Models;

use App\Http\Traits\Scopes;
use Illuminate\Cache\TaggableStore;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Scopes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
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

    protected $appends = ['is_admin'];
    
    public function getCreatedAtAttribute($created_at)
    {
        return $created_at = date("Y-M-d", strtotime($created_at));
    }

    /* define a admin user role */
    public function getIsAdminAttribute()
    {
        return $this->hasRole('admin');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }

    public function cachedRoles()
    {
        $cacheKey = 'roles_for_user_' . $this->id;
     return   Cache::remember($cacheKey, 84600, function () {
            return $this->roles()->get();
        });
    }

    public function hasRole($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }
        return false;
    }

    // public function can($permission, $requireAll = false)
    // {
    //     if (is_array($permission)) {
    //         foreach ($permission as $permName) {
    //             $hasPerm = $this->can($permName);
    //             if ($hasPerm && !$requireAll) {
    //                 return true;
    //             } elseif (!$hasPerm && $requireAll) {
    //                 return false;
    //             }
    //         }
    //         return $requireAll;
    //     } else {
    //         foreach ($this->cachedRoles() as $role) {
    //             // Validate against the Permission table
    //             foreach ($role->cachedPermissions() as $perm) {
    //                 if (str_is( $permission, $perm->name) ) {
    //                     return true;
    //                 }
    //             }
    //         }
    //     }

    //     return false;
    // }
}
