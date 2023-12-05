<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joboffer extends Model
{
    use HasFactory;
    protected $table='job_offer';
    protected $fillable = [
        'name_offer',
        'description',
        'experience',
        'diploma',
        'department_id'
    ];

    public function department(){
        return $this->belongsTo(Department::class);
    }
}
