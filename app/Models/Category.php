<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //

    protected $fillable = ['name', 'description'];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
