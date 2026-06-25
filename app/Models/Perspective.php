<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perspective extends Model
{
    protected $fillable = ['name', 'color', 'hex_color', 'description', 'order'];

    /**
     * All strategic objectives under this perspective.
     */
    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class)->orderBy('order');
    }

    /**
     * All KPIs directly linked to this perspective.
     */
    public function kpis(): HasMany
    {
        return $this->hasMany(Kpi::class);
    }
}
