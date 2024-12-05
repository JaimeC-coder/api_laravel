<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Staff extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'staffId';
    protected $fillable = [
        'stafffirstName',
        'stafflastName',
        'staffBirthDate',
        'staffGender',
        'staffDni',
        'staffAddress',
        'staffPhone',
        'staffPhoto'
    ];

    public function user()
    {
        //relacion de uno a uno
        return $this->hasOne(User::class ,'staffId','staffId'); // relacion de uno a uno con user
    }

    //metodo para devolver el nombre completo
    public function getFullNameAttribute()
    {
        return $this->stafffirstName . ' ' . $this->stafflastName;
    }
    // //metodos set y get para la fecha de nacimiento
    // public function setStaffBirthDateAttribute($value)
    // {
    //     $this->attributes['staffBirthDate'] = date('Y-m-d', strtotime($value));
    // }

    // public function getStaffBirthDateAttribute($value)
    // {
    //     return date('d-m-Y', strtotime($value));
    // }




}
