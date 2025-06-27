<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{
    protected $table = 'uploads';

    protected $fillable = ['name', 'description', 'path', 'user_id', 'project_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function (Upload $upload) {
            Storage::delete($upload->path);
        });
    }
}
