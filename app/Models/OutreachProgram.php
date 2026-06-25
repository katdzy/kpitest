<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutreachProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'program_type',
        'implementing_unit',
        'academic_year',
        'description',
        'target_community',
        'location',
        'partner_agencies',
        'beneficiaries_count',
        'start_date',
        'end_date',
        'status',
        'outcomes',
        'challenges',
        'recommendations',
        'program_coordinator',
        'item_author',
        'date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'date'       => 'date',
    ];

    public static function validationRules($id = null): array
    {
        return [
            'program_name'        => ['required', 'string', 'max:255'],
            'program_type'        => ['required', 'string', 'max:100'],
            'implementing_unit'   => ['required', 'string', 'max:255'],
            'academic_year'       => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'description'         => ['nullable', 'string'],
            'target_community'    => ['nullable', 'string', 'max:255'],
            'location'            => ['nullable', 'string', 'max:255'],
            'partner_agencies'    => ['nullable', 'string'],
            'beneficiaries_count' => ['nullable', 'integer', 'min:0'],
            'start_date'          => ['nullable', 'date'],
            'end_date'            => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'              => ['nullable', 'string', 'in:Planned,Ongoing,Completed,Cancelled'],
            'outcomes'            => ['nullable', 'string'],
            'challenges'          => ['nullable', 'string'],
            'recommendations'     => ['nullable', 'string'],
            'program_coordinator' => ['nullable', 'string', 'max:255'],
            'item_author'         => ['nullable', 'string', 'max:255'],
            'date'                => ['nullable', 'date'],
        ];
    }
}
