<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'roleId';
    protected $fillable = [
        'roleName',
        'roleDescription'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'roleId', 'userId'); // relacion de muchos a muchos con users
    }

    // relacion de muchos a muchos con permisos
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'roleId', 'permissionId'); // relacion de muchos a muchos con permisos
    }




}
