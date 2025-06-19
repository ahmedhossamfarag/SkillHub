<?php

namespace App\Models;

use App\Models\Profile;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    //
    protected $fillable = ['name'];

    public function rules($profile_id, $id = null)
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', new UniqueAttributes('skills', ['profile_id' => $profile_id], $id)],
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
