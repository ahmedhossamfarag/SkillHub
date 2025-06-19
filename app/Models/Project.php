<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
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
}
