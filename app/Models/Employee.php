<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
     		'first_name', 
     		'last_name',
     		'phone',
     		'email',
     		'work_hours',
     		'salary_type',
     		'salary',
     		'department_id '
     	];

    public function department()
    {
    	return $this->belongsTo('App\Models\Department');
    }
}
