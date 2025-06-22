@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('profile.update', $profile) }}" class="flex flex-col gap-3 p-10" id="profileForm">
        @csrf
        @method('PUT')
        <flux:input name="description" type="text" label="{{ __('description') }}" value="{{ old('description') ?? $profile->description }}" />
        <flux:input name="location" type="text" label="{{ __('location') }}" value="{{ old('location') ?? $profile->location }}" />
        <flux:textarea name="experience" type="text" label="{{ __('experience') }}">{{ old('experience') ?? $profile->experience }}
        </flux:textarea>

        <flux:heading>{{ __('skills') }}</flux:heading>
        @error('skills')
            <flux:text color="red">{{ $message }}</flux:text>
        @enderror

        <div x-data="{
            skills: {{ json_encode(old('skills') ?? $profile->skills->pluck('name')->toArray()) }},
            newSkill: '',
            removeSkill(skill) { this.skills = this.skills.filter(t => t !== skill) },
            addSkill() {
                const skill = this.newSkill.trim()
                if (skill && !this.skills.includes(skill))
                    this.skills.push(skill)
                this.newSkill = ''
            }
        }" class="space-y-3">
            <div class="flex gap-3">
                <template x-for="skill in skills">
                    <flux:badge>
                        <span x-text="skill"></span>
                        <flux:badge.close class="cursor-pointer" x-on:click="removeSkill(skill)" />
                        <input type="hidden" name="skills[]" x-bind:value="skill" />
                    </flux:badge>
                </template>
            </div>
            <div class="relative">
                <flux:input x-model="newSkill" placeholder="{{ __('add-skill') }}" x-on:keyup.enter="addSkill" />
                <flux:button x-on:click="addSkill" icon="plus" variant="ghost"
                    class="absolute! top-0 right-0 cursor-pointer" />
            </div>
        </div>

        <flux:heading>{{ __('tags') }}</flux:heading>
        @error('tags')
            <flux:text color="red">{{ $message }}</flux:text>
        @enderror

        <flux:checkbox.group class="flex flex-wrap gap-3">
            @foreach ($tags as $tag)
                <div class="border border-gray-200 p-3 rounded-2xl flex items-center gap-1">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked((old('tags') ?? $profile->tags)->contains($tag))
                        class="cursor-pointer size-5" />
                    <span>{{ $tag->name }}</span>
                </div>
            @endforeach
        </flux:checkbox.group>

        <flux:button type="submit" variant="primary" class="w-full my-3">{{ __('save') }}</flux:button>
    </form>

    <script>
        document.getElementById("profileForm").addEventListener("keydown", function(e) {
            if (e.key === "Enter" && e.target.tagName.toLowerCase() === "input") {
                e.preventDefault();
            }
        });
    </script>
@endsection
