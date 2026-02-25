<div class="p-6 text-surface">
    <div class="bg-white shadow p-4 rounded">
        <h5 class="mb-2 text-xl font-medium leading-tight gap-4">{{ $comment->meeting?->day?? "Sense data" }}</h5>
        <p class="mb-4 text-base">{!! $comment->comment !!}</p>
        <p class="mb-4 text-base">Score: {{ $comment->score }}</p>
        <p class="mb-4 text-base">Autor: {{ $comment->user?->name ?? "Sense nom"}}</p>

        @foreach ($comment->images as $image)
            <a href="/images/{{ $image->url }}" target="_blank">Ver imagen</a>
        @endforeach

        <a href="{{ route('commentCRUD.show', ['commentCRUD' => $comment->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Show</a>
        <a href="{{ route('commentCRUD.edit', ['commentCRUD' => $comment->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        <form action="{{ route('commentCRUD.destroy', ['commentCRUD' => $comment->id]) }}" method="POST" class="float-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
        </form>
    </div>
</div>
