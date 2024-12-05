<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends  Pivot
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'user_roles';
    protected $primaryKey = 'userRoleId';
    protected $fillable = [
        'userId',
        'roleId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId', 'roleId');
    }


}
