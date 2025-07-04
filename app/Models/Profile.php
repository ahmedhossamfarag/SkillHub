<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    //
    protected $fillable = [
        'description',
        'location',
        'experience'
    ];

    public static function rules()
    {
        return [
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'skills' => 'array',
            'skills.*' => 'string|distinct|min:1',
            'tags' => 'array',
            'tags.*' => 'distinct|exists:tags,id',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'profile_tags', 'profile_id', 'tag_id');
    }
}
