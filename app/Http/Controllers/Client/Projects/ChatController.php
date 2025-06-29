<?php

namespace App\Http\Controllers\Client\Projects;

use App\Models\Project;
use App\Events\MessageSent;
use App\Events\Test;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ChatController
{
    public function index(Project $project)
    {
        Gate::authorize('viewAny', [ChatMessage::class, $project]);
        $messagesCollection = ChatMessage::with('user')->where('project_id', $project->id)->get();
        $messages = [];
        foreach ($messagesCollection as $message) {
            array_push($messages, [
                'user_id' => $message->user->id,
                'user_name' => $message->user->name,
                'user_avatar' => $message->user->avatar,
                'message' => $message->message
            ]);
        }
        
        return view('client.projects.chat.index')->with('project', $project)->with('messages', $messages);
    }

    public function store(Request $request, Project $project)
    {
        Gate::authorize('create', [ChatMessage::class, $project]);
        $request->validate([
            'message' => 'required|string|max:255',
        ]);
        $message = ChatMessage::create([
            'user_id' => $request->user()->id,
            'project_id' => $project->id,
            'message' => $request->message,
        ]);
        broadcast(new MessageSent($project, $request->user(), $message));
        return response()->json($message);
    }
}
