<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table='department';
    protected $fillable = ['id','name_department','user_id'];

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function joboffer(){
        return $this->hasMany(Joboffer::class);
    }

}
