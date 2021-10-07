<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guarded = [];

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
