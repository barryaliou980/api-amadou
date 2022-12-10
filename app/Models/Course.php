<?php

namespace App\Models;

class Course extends BaseModel
{
    protected $fillable = [
        'course_name',
        'course_description',
        'school_year',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
