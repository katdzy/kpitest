<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'lead_researcher',
        'academic_year',
        'co_researchers',
        'implementing_unit',
        'funding_source',
        'funding_amount',
        'status',
        'start_date',
        'end_date',
        'abstract',
        'keywords',
        'output_type',
        'publication_title',
        'isbn_issn',
        'indexed_in',
        'doi',
        'citation_count',
        'remarks',
        'item_author',
        'date',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'date'           => 'date',
        'funding_amount' => 'decimal:2',
    ];

    public static function validationRules($id = null): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'type'              => ['required', 'string', 'max:100'],
            'lead_researcher'   => ['required', 'string', 'max:255'],
            'academic_year'     => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'co_researchers'    => ['nullable', 'string'],
            'implementing_unit' => ['nullable', 'string', 'max:255'],
            'funding_source'    => ['nullable', 'string', 'max:255'],
            'funding_amount'    => ['nullable', 'numeric', 'min:0'],
            'status'            => ['nullable', 'string', 'in:Proposed,Ongoing,Completed,Published,Discontinued'],
            'start_date'        => ['nullable', 'date'],
            'end_date'          => ['nullable', 'date', 'after_or_equal:start_date'],
            'abstract'          => ['nullable', 'string'],
            'keywords'          => ['nullable', 'string', 'max:500'],
            'output_type'       => ['nullable', 'string', 'max:100'],
            'publication_title' => ['nullable', 'string', 'max:500'],
            'isbn_issn'         => ['nullable', 'string', 'max:100'],
            'indexed_in'        => ['nullable', 'string', 'max:255'],
            'doi'               => ['nullable', 'string', 'max:255'],
            'citation_count'    => ['nullable', 'string', 'max:50'],
            'remarks'           => ['nullable', 'string'],
            'item_author'       => ['nullable', 'string', 'max:255'],
            'date'              => ['nullable', 'date'],
        ];
    }
}
