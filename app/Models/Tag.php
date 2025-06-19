<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    //
    protected $fillable = ['name', 'description'];

    public function profile(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profile_tags', 'tag_id', 'profile_id');
    }
}
