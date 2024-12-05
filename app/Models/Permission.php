<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory , SoftDeletes;
 

    protected $primaryKey = 'permissionId';
    protected $fillable = [
        'permissionName',
        'permissionDescription'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permissionId', 'roleId'); // relacion de muchos a muchos con roles
    }

}
