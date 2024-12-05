<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Pivot
{
    use HasFactory , SoftDeletes;
  
    protected $table = 'role_permissions';
    protected $primaryKey = 'rolePermissionId';
    protected $fillable = [
        'roleId',
        'permissionId'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'roleId');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permissionId', 'permissionId');
    }

}
