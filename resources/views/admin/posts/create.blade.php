@extends('dashboard.admin', ['current' => 'posts'])

@section('main-content')
    <form method="POST" action="{{ route('admin.posts.store') }}" class="flex flex-col gap-3 p-10"
        enctype="multipart/form-data">
        @csrf
        <flux:textarea name="content" label="{{ __('content') }}" id="post-content"></flux:textarea>
        <flux:input type="file" name="image" label="{{ __('image') }}" />
        <flux:button type="submit" variant="primary" class="w-full cursor-pointer">{{ __('save') }}</flux:button>
    </form>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#post-content'))
            .then(editor => {
                editor.editing.view.change(writer => {
                    writer.setStyle('background-color', 'white', editor.editing.view.document.getRoot());
                    writer.setStyle('color', 'black', editor.editing.view.document.getRoot());
                    writer.setStyle('min-height', '300px', editor.editing.view.document.getRoot());
                });
            })
            .catch(error => {
                window.alert(error);
            })
    </script>
@endsection
