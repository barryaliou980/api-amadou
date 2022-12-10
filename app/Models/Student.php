<?php

namespace App\Models;

class Student extends BaseModel
{
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
        'age',
        'gender',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
