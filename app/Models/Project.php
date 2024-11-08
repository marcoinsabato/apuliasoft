<?php

namespace App\Models;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the activities associated with the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Activity>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}
