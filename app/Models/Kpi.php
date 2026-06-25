<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kpi extends Model
{
    use HasFactory;

    /** KPI scope values */
    public const SCOPE_INSTITUTIONAL = 'Institutional';
    public const SCOPE_DEPARTMENTAL  = 'Departmental';

    /** KPI lifecycle status values */
    public const STATUS_DRAFT        = 'Draft';
    public const STATUS_UNDER_REVIEW = 'Under Review';
    public const STATUS_APPROVED     = 'Approved';
    public const STATUS_ACTIVE       = 'Active';
    public const STATUS_ARCHIVED     = 'Archived';

    /** Allowed status values (ordered by lifecycle stage) */
    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_UNDER_REVIEW,
        self::STATUS_APPROVED,
        self::STATUS_ACTIVE,
        self::STATUS_ARCHIVED,
    ];

    /** Valid transitions from each status */
    public const STATUS_TRANSITIONS = [
        self::STATUS_DRAFT        => [self::STATUS_UNDER_REVIEW],
        self::STATUS_UNDER_REVIEW => [self::STATUS_DRAFT, self::STATUS_APPROVED],
        self::STATUS_APPROVED     => [self::STATUS_ACTIVE, self::STATUS_UNDER_REVIEW],
        self::STATUS_ACTIVE       => [self::STATUS_ARCHIVED, self::STATUS_UNDER_REVIEW],
        self::STATUS_ARCHIVED     => [self::STATUS_DRAFT],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'scope',
        'measure_code',
        'measure_owner',
        'measure_name',
        'measure_type',
        'category',
        'year_range',
        'description',
        'lead_lag',
        'polarity',
        'formula',
        'unit_type',
        'data_provider',
        'data_source',
        'collection_frequency',
        'reporting_frequency',
        'verified_by',
        'validated_by',
        'baseline',
        'target',
        'high_threshold',
        'low_threshold',
        'target_rationale',
        'perspective',
        'strategic_theme',
        'objective',
        'objective_owner',
        'strategic_initiatives',
        'intended_results',
        'comparator',
        'item_author',
        'date',
        'status',
        'status_changed_at',
        // BSC alignment
        'perspective_id',
        'objective_id',
        // 5-year annual targets
        'target_2024',
        'target_2025',
        'target_2026',
        'target_2027',
        'target_2028',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date'              => 'date',
        'status_changed_at' => 'datetime',
        'perspective_id'    => 'integer',
        'objective_id'      => 'integer',
    ];

    // ──────────────────────────────────────────────
    // BSC Hierarchy Relationships
    // ──────────────────────────────────────────────

    /**
     * The BSC Perspective this KPI belongs to.
     */
    public function bscPerspective(): BelongsTo
    {
        return $this->belongsTo(Perspective::class, 'perspective_id');
    }

    /**
     * The BSC Strategic Objective this KPI supports.
     */
    public function bscObjective(): BelongsTo
    {
        return $this->belongsTo(Objective::class, 'objective_id');
    }

    /**
     * Get all 5-year annual targets as a keyed array.
     */
    public function annualTargets(): array
    {
        return [
            '2024' => $this->target_2024,
            '2025' => $this->target_2025,
            '2026' => $this->target_2026,
            '2027' => $this->target_2027,
            '2028' => $this->target_2028,
        ];
    }

    /**
     * Get the target for the given start year (e.g. 2025 for AY 2025-2026).
     */
    public function targetForYear(int $year): ?string
    {
        return $this->{'target_' . $year} ?? null;
    }

    /**
     * The parent (institutional) KPI that this departmental KPI rolls up into.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Kpi::class, 'parent_id');
    }

    /**
     * Departmental child KPIs that roll up into this institutional KPI.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Kpi::class, 'parent_id');
    }

    /**
     * All departments assigned to this KPI (with their role on the pivot).
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class, 'kpi_assignments')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * All periodic performance results for this KPI.
     */
    public function results(): HasMany
    {
        return $this->hasMany(KpiResult::class);
    }

    /**
     * The single most recent performance result (for dashboard cards).
     */
    public function latestResult(): HasOne
    {
        return $this->hasOne(KpiResult::class)->latestOfMany('created_at');
    }

    // ──────────────────────────────────────────────
    // Helper Methods
    // ──────────────────────────────────────────────

    /**
     * Get other versions of the same KPI code (different year ranges).
     */
    public function otherVersions()
    {
        return self::where('measure_code', $this->measure_code)
            ->where('id', '!=', $this->id)
            ->orderBy('year_range', 'desc')
            ->get();
    }

    /**
     * Whether this KPI has a specific status.
     */
    public function hasStatus(string $status): bool
    {
        return $this->status === $status;
    }

    public function isDraft(): bool        { return $this->status === self::STATUS_DRAFT; }
    public function isUnderReview(): bool  { return $this->status === self::STATUS_UNDER_REVIEW; }
    public function isApproved(): bool     { return $this->status === self::STATUS_APPROVED; }
    public function isActive(): bool       { return $this->status === self::STATUS_ACTIVE; }
    public function isArchived(): bool     { return $this->status === self::STATUS_ARCHIVED; }

    /**
     * Get the allowed next statuses from the current one.
     */
    public function allowedTransitions(): array
    {
        return self::STATUS_TRANSITIONS[$this->status] ?? [];
    }

    /**
     * Whether this KPI can transition to a given status.
     */
    public function canTransitionTo(string $status): bool
    {
        return in_array($status, $this->allowedTransitions(), true);
    }

    /**
     * Transition the KPI to a new status (with timestamp).
     */
    public function transitionTo(string $status): bool
    {
        if (!$this->canTransitionTo($status)) {
            return false;
        }

        $this->update([
            'status'            => $status,
            'status_changed_at' => now(),
        ]);

        return true;
    }

    /**
     * Whether this KPI is institutional (university-wide).
     */
    public function isInstitutional(): bool
    {
        return $this->scope === self::SCOPE_INSTITUTIONAL;
    }

    /**
     * Whether this KPI is departmental.
     */
    public function isDepartmental(): bool
    {
        return $this->scope === self::SCOPE_DEPARTMENTAL;
    }

    /**
     * Get validation rules for KPI operations.
     */
    public static function validationRules($id = null)
    {
        // Unique check for combination of measure_code and year_range
        $uniqueRule = 'unique:kpis,measure_code';
        if ($id) {
            $uniqueRule .= ',' . $id;
        }

        return [
            'parent_id'    => ['nullable', 'exists:kpis,id'],
            'scope'        => ['required', 'string', 'in:Institutional,Departmental'],
            'measure_code' => ['required', 'string', 'max:50'],
            'measure_owner' => ['required', 'string', 'max:255'],
            'measure_name' => ['required', 'string', 'max:255'],
            'measure_type' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'year_range' => [
                'required', 
                'string', 
                'regex:/^\d{4}-\d{4}$/', // e.g. 2025-2026
                function ($attribute, $value, $fail) use ($id) {
                    // Custom validation for composite uniqueness of measure_code and year_range
                    $measureCode = request()->input('measure_code');
                    if ($measureCode) {
                        $query = self::where('measure_code', $measureCode)
                            ->where('year_range', $value);
                        
                        if ($id) {
                            $query->where('id', '!=', $id);
                        }
                        
                        if ($query->exists()) {
                            $fail("A KPI version for code '{$measureCode}' and year range '{$value}' already exists.");
                        }
                    }
                }
            ],
            'status'           => ['nullable', 'string', 'in:Draft,Under Review,Approved,Active,Archived'],
            'perspective_id'   => ['nullable', 'exists:perspectives,id'],
            'objective_id'     => ['nullable', 'exists:objectives,id'],
            'target_2024'      => ['nullable', 'string', 'max:100'],
            'target_2025'      => ['nullable', 'string', 'max:100'],
            'target_2026'      => ['nullable', 'string', 'max:100'],
            'target_2027'      => ['nullable', 'string', 'max:100'],
            'target_2028'      => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'lead_lag' => ['nullable', 'string', 'in:Lead,Lag'],
            'polarity' => ['nullable', 'string', 'in:Positive,Negative,Neutral'],
            'formula' => ['nullable', 'string'],
            'unit_type' => ['nullable', 'string', 'max:100'],
            'data_provider' => ['nullable', 'string', 'max:255'],
            'data_source' => ['nullable', 'string', 'max:255'],
            'collection_frequency' => ['nullable', 'string', 'max:100'],
            'reporting_frequency' => ['nullable', 'string', 'max:100'],
            'verified_by' => ['nullable', 'string', 'max:255'],
            'validated_by' => ['nullable', 'string', 'max:255'],
            'baseline' => ['nullable', 'string', 'max:100'],
            'target' => ['nullable', 'string', 'max:100'],
            'high_threshold' => ['nullable', 'string', 'max:100'],
            'low_threshold' => ['nullable', 'string', 'max:100'],
            'target_rationale' => ['nullable', 'string'],
            'perspective' => ['nullable', 'string', 'max:255'],
            'strategic_theme' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string', 'max:255'],
            'objective_owner' => ['nullable', 'string', 'max:255'],
            'strategic_initiatives' => ['nullable', 'string'],
            'intended_results' => ['nullable', 'string'],
            'comparator' => ['nullable', 'string', 'max:255'],
            'item_author' => ['nullable', 'string', 'max:255'],
            'date' => ['nullable', 'date'],
        ];
    }
}
