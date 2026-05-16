<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'answer',
        'user_id',
        'student_assessment_id',
        'course_question_id',
    ];

    public function question() {
        return $this->belongsTo(CourseQuestion::class, 'course_question_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assessment() {
        return $this->belongsTo(StudentAssessment::class, 'student_assessment_id');
    }
}
