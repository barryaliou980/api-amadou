<?php

namespace App\Models;

class Instructor extends BaseModel
{
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'gender',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
