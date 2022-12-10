<?php

namespace App\Models;

class Subject extends BaseModel
{
    protected $guarded = ['id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

     public function schedules()
     {
         return $this->hasMany(Schedule::class);
     }
}
