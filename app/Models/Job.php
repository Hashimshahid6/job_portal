<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    
    public function jobType(){
        return $this->belongsTo(JobType::class);
    }//end of jobType

    public function category(){
        return $this->belongsTo(Category::class);
    }//end of category

    public function applications(){
        return $this->hasMany(JobApplication::class);
    }//end of applications
    
    public function user(){
        return $this->belongsTo(User::class);
    }//end of user
}
