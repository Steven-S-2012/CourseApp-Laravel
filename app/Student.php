<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email'
    ];

    protected $appends = [
        'name'
    ];

    public function courses() {
        return $this->belongsToMany(Course::class);
    }

    public function getNameAttribute() {
        $fullName = $this->first_name . ' ' .$this->last_name;
        return $fullName;
    }
}
