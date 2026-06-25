<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'beneficiary_type',
        'academic_year',
        'description',
        'funding_source',
        'administering_unit',
        'amount',
        'currency',
        'beneficiaries_count',
        'selection_criteria',
        'start_date',
        'end_date',
        'status',
        'outcomes',
        'remarks',
        'item_author',
        'date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'date'       => 'date',
        'amount'     => 'decimal:2',
    ];

    public static function validationRules($id = null): array
    {
        return [
            'title'              => ['required', 'string', 'max:255'],
            'type'               => ['required', 'string', 'max:100'],
            'beneficiary_type'   => ['required', 'string', 'max:100'],
            'academic_year'      => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'description'        => ['nullable', 'string'],
            'funding_source'     => ['nullable', 'string', 'max:255'],
            'administering_unit' => ['nullable', 'string', 'max:255'],
            'amount'             => ['nullable', 'numeric', 'min:0'],
            'currency'           => ['nullable', 'string', 'max:10'],
            'beneficiaries_count'=> ['nullable', 'integer', 'min:0'],
            'selection_criteria' => ['nullable', 'string', 'max:255'],
            'start_date'         => ['nullable', 'date'],
            'end_date'           => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'             => ['nullable', 'string', 'in:Active,Completed,Pending,Suspended'],
            'outcomes'           => ['nullable', 'string'],
            'remarks'            => ['nullable', 'string'],
            'item_author'        => ['nullable', 'string', 'max:255'],
            'date'               => ['nullable', 'date'],
        ];
    }
}
