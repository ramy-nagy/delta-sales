<?php

namespace App\Models;

use App\Http\Traits\Scopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory, Scopes;
    protected $fillable = ['name', 'display_name', 'description'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function cachedPermissions()
    {
        $cacheKey = 'permissions_for_role_' . $this->id;
        return   Cache::remember($cacheKey, 84600, function () {
            return $this->permissions()->get();
        });
    }
}
