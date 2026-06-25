<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiAssignment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kpi_id',
        'department_id',
        'role',
    ];

    /**
     * Valid roles a department can hold on a KPI.
     */
    public const ROLES = [
        'Strategic Owner' => 'Strategic Owner',
        'Data Provider'   => 'Data Provider',
        'Contributor'     => 'Contributor',
    ];

    /**
     * The KPI this assignment belongs to.
     */
    public function kpi(): BelongsTo
    {
        return $this->belongsTo(Kpi::class);
    }

    /**
     * The department this assignment belongs to.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
