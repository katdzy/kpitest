<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Objective extends Model
{
    protected $fillable = [
        'perspective_id',
        'code',
        'title',
        'intended_result',
        'owner',
        'order',
    ];

    /**
     * The BSC Perspective this objective belongs to.
     */
    public function perspective(): BelongsTo
    {
        return $this->belongsTo(Perspective::class);
    }

    /**
     * All KPIs that support this strategic objective.
     */
    public function kpis(): HasMany
    {
        return $this->hasMany(Kpi::class);
    }
}
