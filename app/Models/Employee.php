<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'age', 'salary', 'function', 'sexe', 'date_of_employement', 'phone_number','departement_id'];

   
    public function offs()
    {
        return $this->hasMany(Off::class);
    }

    public function departement(){
        return $this->belongsTo(Department::class);
    }
}
