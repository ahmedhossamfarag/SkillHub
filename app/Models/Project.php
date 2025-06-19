<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    //
    protected $table = 'projects';
    protected $fillable = [
        'title',
        'description',
        'budget',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'budget' => 'integer',
    ];

    public static function rules($user_id, $id = null){
        return [
            'title' => ['required', 'string', 'max:255', 'min:3', new UniqueAttributes('projects', ['client_id' => $user_id], $id)],
            'description' => 'required|string|max:255',
            'budget' => 'required|integer|min:0',
            'deadline' => 'required|date',
        ];
    }

    public function catogory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'catogory_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }


    public function freelancers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_freelancers', 'project_id', 'freelancer_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'project_id');
    }
}
