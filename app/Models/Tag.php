<?php

namespace App\Models;

use App\Models\Profile;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    //
    protected $fillable = ['name', 'description'];

    public static function rules($id = null){
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', new UniqueAttributes('tags', [], $id)],
            'description' => 'required|string|max:255',
        ];
    }

    public function profile(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'profile_tags', 'tag_id', 'profile_id');
    }
}
