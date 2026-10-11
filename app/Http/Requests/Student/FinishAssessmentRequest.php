<?php

namespace App\Http\Requests\Student;

use App\Models\StudentAssessment;
use Illuminate\Foundation\Http\FormRequest;

class FinishAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => 'nullable|array',
            'violations_count' => 'nullable|integer|min:0',
            'submitted_reason' => 'nullable|string|in:' . implode(',', [
                StudentAssessment::REASON_NORMAL,
                StudentAssessment::REASON_TIMEOUT,
                StudentAssessment::REASON_VIOLATION_LIMIT,
            ]),
        ];
    }
}
