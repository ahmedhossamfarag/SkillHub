<?php

namespace App\Models;

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
        'review_type' => 'enum:client,freelancer',
    ];


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
}
