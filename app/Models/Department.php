<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'description',
        'college',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all KPIs associated with this department (via kpi_assignments).
     */
    public function kpis(): BelongsToMany
    {
        return $this->belongsToMany(Kpi::class, 'kpi_assignments')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    /**
     * Get all KPI result entries reported by this department.
     */
    public function kpiResults(): HasMany
    {
        return $this->hasMany(KpiResult::class);
    }

    /**
     * Scope: only active departments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
