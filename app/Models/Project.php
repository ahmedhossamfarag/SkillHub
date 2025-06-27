<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class Project extends Model
{

    use Searchable;

    public function searchableAs()
    {
        return 'projects_index';
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'budget' => $this->budget,
            'deadline' => $this->deadline,
            'created_at' => $this->created_at,
            'category_id' => $this->category_id,
        ];
    }

    //
    protected $table = 'projects';
    protected $fillable = [
        'title',
        'description',
        'budget',
        'deadline',
        'category_id',
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'budget' => 'integer',
        'category_id' => 'integer',
    ];

    public static function rules($user_id, $id = null){
        return [
            'title' => ['required', 'string', 'max:255', 'min:3', new UniqueAttributes('projects', ['client_id' => $user_id], $id)],
            'description' => 'required|string|max:255',
            'budget' => 'required|integer|min:0',
            'deadline' => 'required|date',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
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

    public function uploads(): HasMany
    {
        return $this->hasMany(Upload::class, 'project_id');
    }
}
