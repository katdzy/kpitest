<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'level',
        'accrediting_body',
        'academic_year',
        'accreditation_level',
        'status',
        'validity_start',
        'validity_end',
        'certifying_officer',
        'college_department',
        'last_survey_date',
        'next_survey_date',
        'survey_visit_count',
        'conditions',
        'remarks',
        'focal_person',
        'item_author',
        'date',
    ];

    protected $casts = [
        'validity_start'   => 'date',
        'validity_end'     => 'date',
        'last_survey_date' => 'date',
        'next_survey_date' => 'date',
        'date'             => 'date',
    ];

    /**
     * Determine if the accreditation is expiring within 90 days.
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->validity_end) return false;
        return $this->validity_end->isPast() === false
            && $this->validity_end->diffInDays(now()) <= 90;
    }

    public static function validationRules($id = null): array
    {
        return [
            'program_name'        => ['required', 'string', 'max:255'],
            'level'               => ['required', 'string', 'in:Program,Institutional,Department'],
            'accrediting_body'    => ['required', 'string', 'max:255'],
            'academic_year'       => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'accreditation_level' => ['nullable', 'string', 'max:100'],
            'status'              => ['nullable', 'string', 'in:Active,Pending,Expired,Under Surveillance,Withdrawn'],
            'validity_start'      => ['nullable', 'date'],
            'validity_end'        => ['nullable', 'date', 'after_or_equal:validity_start'],
            'certifying_officer'  => ['nullable', 'string', 'max:255'],
            'college_department'  => ['nullable', 'string', 'max:255'],
            'last_survey_date'    => ['nullable', 'date'],
            'next_survey_date'    => ['nullable', 'date'],
            'survey_visit_count'  => ['nullable', 'integer', 'min:0'],
            'conditions'          => ['nullable', 'string'],
            'remarks'             => ['nullable', 'string'],
            'focal_person'        => ['nullable', 'string', 'max:255'],
            'item_author'         => ['nullable', 'string', 'max:255'],
            'date'                => ['nullable', 'date'],
        ];
    }
}
