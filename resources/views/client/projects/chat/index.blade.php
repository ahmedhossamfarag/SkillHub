@extends('client.projects.layout', ['current' => 'chat'])

@section('main-content')
    <div class="flex flex-col h-screen p-10 pb-20"
        x-data='{
        message: "",
        send() {
            if (this.message.trim() == "") return;
            sendMessage(this.message);
            $store.messages.data.push({ user_id: "{{ auth()->user()->id }}", user_name: "{{ auth()->user()->name }}", user_avatar: "{{ auth()->user()->avatar }}", message: this.message });
            this.message = "";
        },
        init() {
            Alpine.store("messages", { data: @json($messages) });
        }
    }'
        x-init="init()">
        <div class="max-h-full flex flex-col w-full overflow-y-scroll p-2">
            <template x-for="message in $store.messages.data">
                <div x-bind:class="message.user_id == '{{ auth()->user()->id }}' ? 'self-end' : ''"
                    class="rounded-2xl p-3 mb-3 space-y-1 bg-[#1d1d20] w-fit">
                    <div class="flex gap-1 items-center">
                        <template x-if="message.user_avatar">
                            <img class="w-5 h-5 rounded-full" x-bind:src="message.user_avatar" />
                        </template>
                        <template x-if="! message.user_avatar">
                            <flux:icon icon="user-circle" class="w-5 h-5" />
                        </template>
                        <flux:heading x-text="message.user_name"></flux:heading>
                    </div>
                    <flux:separator></flux:separator>
                    <flux:text x-text="message.message"></flux:text>
            </template>
        </div>
        <div class="relative w-full">
            <flux:input id="message" class="w-full" x-model="message" />
            <flux:button icon="paper-airplane" variant="primary" color="green" x-on:click="send"
                class="absolute! right-0 top-1/2 transform -translate-y-1/2 cursor-pointer" />
        </div>
    </div>
    <script type="module">
        window.sendMessage = function(message) {
            fetch('{{ route('client.projects.messages.store', $project) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message: message
                })
            }).then(response => {});
        }
        Echo.join('{{ 'chat.' . $project->id }}')
            .here((users) => {
                console.log(users);
            })
            .joining((user) => {}) // new user joined
            .leaving((user) => {}) // user left
            .error((error) => {
                console.error(error);
            })
            .listen('.message.sent', (e) => {
                // Alpine.store('messages').data.push(e.message);
                console.log(e);
            });
    </script>
@endsection
