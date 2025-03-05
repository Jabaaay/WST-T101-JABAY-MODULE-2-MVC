<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_code',
        'name',
        'description',
        'credits'
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->count();
    }
}
