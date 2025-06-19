<?php

namespace App\Models;

use App\Models\Project;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //

    protected $fillable = ['name', 'description'];

    public static function rules($id = null){
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', new UniqueAttributes('categories', [], $id)],
            'description' => 'required|string|max:255',
        ];
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
