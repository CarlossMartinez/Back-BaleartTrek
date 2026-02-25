<x-app-layout>
    <x-slot name="header">
        <h2>Editar Comentari</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('commentCRUD.update', $comment) }}" method="POST">
            @csrf
            @method('PUT')

            <select name="meeting_id">
                @foreach ($meetings as $title => $id)
                    <option value="{{ $id }}"
                        @selected(old('meeting_id', $comment->meeting_id) == $id)>
                        {{ $title }}
                    </option>
                @endforeach
            </select>

            <select name="score">
                @for ($s = 1; $s <= 5; $s++)
                    <option value="{{ $s }}"
                        @selected(old('score', $comment->score) == $s)>
                        {{ $s }}
                    </option>
                @endfor
            </select>

            <textarea name="comment">{{ old('comment', $comment->comment) }}</textarea>

            <button class="bg-green-500 text-white px-4 py-2 mt-3">
                Guardar
            </button>
        </form>

        <hr class="my-4">

        <form action="{{ route('comment.image', $comment) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <input type="file" name="url">
            <button class="bg-blue-500 text-white px-4 py-2">
                Pujar Imatge
            </button>
        </form>

        @foreach ($comment->images as $image)
            <div class="mt-2">
                <img src="/images/{{ $image->url }}" class="max-w-xs">

                <form action="{{ route('image.destroy', $image) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button class="bg-red-500 text-white px-2 py-1">
                        Eliminar
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>