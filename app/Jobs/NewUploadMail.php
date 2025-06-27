<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\WithoutRelations;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewUploadMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        #[WithoutRelations]
        public $project,
        public $user,
        public $name,
        public $description
    )
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $client = $this->project->client;
        $freelancers = $this->project->freelancers;

        Mail::to($client->email)->send(new \App\Mail\NewUpload($this->user, $this->project, $this->name, $this->description));

        foreach($freelancers as $freelancer){
            Mail::to($freelancer->email)->send(new \App\Mail\NewUpload($this->user, $this->project, $this->name, $this->description));
        }
    }
}
