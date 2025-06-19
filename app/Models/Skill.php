<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    //
    protected $fillable = ['name'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
