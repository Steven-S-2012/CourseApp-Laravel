<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'title',
        'email',
        'introduction'
    ];

    protected $appends =[
        'name'
    ];

    public function courses() {
        return $this->belongsToMany(Course::class);
    }

    public function getNameAttribute() {
        $fullName = $this->first_name.' '.$this->last_name;
//        $fullName = $this->getAttribute('first_name').' '.$this->getAttribute('last_name');
        return $fullName;
    }
}
