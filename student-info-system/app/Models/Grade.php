<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'enrollment_id',
        'grade',
        'score',
        'remarks'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
