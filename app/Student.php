<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','email','phone_no', 'father_name', 'course_id','joined_date'];
}
