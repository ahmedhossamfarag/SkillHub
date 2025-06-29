<?php

use App\Models\ChatMessage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{project}', function (User $user, Project $project) {
    if ($user->can('create', [ChatMessage::class, $project])){
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
});
