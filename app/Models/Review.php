<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use App\Rules\ProjectExist;
use App\Rules\UniqueAttributes;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'rating',
        'comment',
        'review_type',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public static function rules($client_id, $freelancer_id, $project_id, $id = null){
        return [
            'rating' => 'required|integer|min:1|max:10',
            'comment' => 'required|string|max:255',
            'client_id' => 'required',
            'project_id' => ['required', new ProjectExist($client_id, $freelancer_id)],
            'review_type' => ['required', 'in:client,freelancer', new UniqueAttributes('reviews', ['client_id' => $client_id, 'freelancer_id' => $freelancer_id, 'project_id' => $project_id], $id)],
        ];
    }


    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function freelancer()
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public static function getFillableFields(){
        return [
            'rating',
            'comment',
            'review_type',
        ];
    }
}
