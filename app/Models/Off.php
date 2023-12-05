<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Off extends Model
{
    use HasFactory;
    protected $fillable = ['off_col', 'start_date', 'end_date', 'days_number', 'employee_id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
   
   


}

