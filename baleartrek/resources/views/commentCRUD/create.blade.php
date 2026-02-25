<x-app-layout>
    <x-slot name="header">
        <h2>Crear comentari</h2>
    </x-slot>

    <div class="p-6">
        @include('components.alert')

        <form action="{{ route('commentCRUD.store') }}" method="POST">
            @csrf

            <label>Trobada</label>
            <select name="meeting_id" class="block w-full">
                @foreach ($meetings as $title => $id)
                    <option value="{{ $id }}">{{ $title }}</option>
                @endforeach
            </select>

            <label>Puntuació</label>
            <select name="score" class="block w-full">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>

            <label>Comentarí</label>
            <textarea name="comment" class="block w-full"></textarea>

            <button class="bg-blue-500 text-white px-4 py-2 mt-3">
                Crear
            </button>
        </form>
    </div>
</x-app-layout>