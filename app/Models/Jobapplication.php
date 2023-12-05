<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobapplication extends Model
{
    use HasFactory;
    protected $table='job_applications';
    protected $fillable = ['job_offer_id','user_id','text','salary'];
    public function joboffer(){
        return $this->belongsTo(Joboffer::class,"job_offer_id");
    }
    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
}
