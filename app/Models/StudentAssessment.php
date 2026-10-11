<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAssessment extends Model
{
    use HasFactory, SoftDeletes;

    public const REASON_NORMAL = 'normal';
    public const REASON_TIMEOUT = 'timeout';
    public const REASON_VIOLATION_LIMIT = 'violation_limit';

    public const MAX_VIOLATIONS_ALLOWED = 3;

    protected $fillable = [
        'user_id',
        'course_id',
        'score',
        'violations_count',
        'submitted_reason',
        'started_at',
        'finished_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
