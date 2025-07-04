<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proposal extends Model
{
    //
    protected $fillable = [
        'paid_amount',
        'estimated_time',
        'status'
    ];

    protected $casts = [
        'paid_amount' => 'integer',
    ];

    public static function rules(){
        return [
            'paid_amount' => 'required|integer|min:0',
            'estimated_time' => 'required',
            'status' => 'in:pending,accepted,rejected',
            'project_id' => 'required|exists:projects,id',
        ];
    }
    

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function freelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}
