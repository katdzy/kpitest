<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiResult extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kpi_id',
        'department_id',
        'school_year',
        'report_type',
        'period',
        'actual_value',
        'target_value',
        'baseline_value',
        'status',
        'notes',
        'submitted_by',
        'submitted_at',
        'initiative_outcome',
        'is_final',
        'imported_from',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'actual_value'   => 'double',
        'target_value'   => 'double',
        'baseline_value' => 'double',
        'submitted_at'   => 'datetime',
        'is_final'       => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────────────────

    /** Scope to only Mid-Year reports. */
    public function scopeMidYear($query)
    {
        return $query->where('report_type', 'Mid-Year');
    }

    /** Scope to only Year-Ender reports. */
    public function scopeYearEnder($query)
    {
        return $query->where('report_type', 'Year-Ender');
    }

    /**
     * The KPI this result belongs to.
     */
    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }

    /**
     * The department that reported this result (null = university-wide).
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Compute the performance status based on actual vs. target and KPI polarity.
     * Call this before saving when actual_value is set.
     *
     * Thresholds (positive polarity):
     *   On Track  : actual >= 95% of target
     *   Warning   : actual >= 85% of target
     *   Off Track : actual <  85% of target
     *
     * For negative polarity (lower is better) the logic is inverted.
     */
    public function computeStatus(): string
    {
        if ($this->actual_value === null || $this->target_value == 0) {
            return 'Pending';
        }

        $ratio = $this->actual_value / $this->target_value;
        $polarity = $this->kpi?->polarity ?? 'Positive';

        if ($polarity === 'Negative') {
            // Lower actual is better (e.g. emissions reduction metric stored as a cost)
            if ($ratio <= 1.05) return 'On Track';
            if ($ratio <= 1.15) return 'Warning';
            return 'Off Track';
        }

        // Positive polarity — higher is better
        if ($ratio >= 0.95) return 'On Track';
        if ($ratio >= 0.85) return 'Warning';
        return 'Off Track';
    }

    /**
     * Return a Tailwind CSS color class for the current status.
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'On Track' => 'emerald',
            'Warning'  => 'amber',
            'Off Track'=> 'red',
            default    => 'slate',
        };
    }
}
