<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'status',
        'academic_year',
        'semester'
    ];

    protected $guarded = ['id'];

    // Define the allowed status values
    const STATUS_ENROLLED = 'enrolled';
    const STATUS_PENDING = 'pending';
    const STATUS_DROPPED = 'dropped';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_ENROLLED => 'Enrolled',
            self::STATUS_PENDING => 'Pending',
            self::STATUS_DROPPED => 'Dropped'
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade()
    {
        return $this->hasOne(Grade::class);
    }
}
