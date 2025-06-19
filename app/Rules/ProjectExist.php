<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class ProjectExist implements ValidationRule
{

    public function __construct(
        private $client_id,
        private $freelancer_id
    ){}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = DB::table('projects')->join('project_freelancers', 'projects.id', '=', 'project_freelancers.project_id')
            ->where('projects.client_id', $this->client_id)
            ->where('project_freelancers.freelancer_id', $this->freelancer_id)
            ->where('projects.id', $value);

        if (!$query->exists()) {
            $fail('Project does not exist.');
        }
    }
}
