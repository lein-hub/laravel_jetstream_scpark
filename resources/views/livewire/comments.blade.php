<div>
    <div>
        @if(session()->has('message'))
        <div class="p-3 text-green-800 bg-green-300 rounded shadow-sm">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <form class="flex my-4" wire:submit.prevent="addComment">
        <input wire:model.lazy="newComment" type="text" class="w-full p-2 my-2 mr-2 border rounded shadow" placeholder="new comment here">
        @error("newComment")
            <span class="text-red-500">{{ $message }}</span>
        @enderror
        <div class="py-2">
            <button class="w-20 p-2 text-white bg-blue-500">submit</button>
        </div>
    </form>
    @foreach($comments as $comment)
    {{-- <div class="card shadow-sm bg-neutral text-accent-content mb-5">
        <figure>
            @if($comment->image)
            <img src="{{ $comment->image }}">
            @endif
        </figure>
        <div class="card-body">
          <h2 class="card-title">Top image
            <div class="badge mx-2 bg-pink-300">NEW</div>
          </h2>
          <p>{{ $comment->content }}</p>
          <div class="justify-end card-actions">
            <button class="btn bg-pink-300">More info</button>
          </div>
        </div>
      </div> --}}
      <div class="p-3 my-2 border rounded shadow">
          <div class="flex justify-between my-2">
            <div class="flex">
                <p class="text-lg font-bold text-gray-800">
                    {{ $comment->writer->name }}
                </p>
                <p class="py-1 mx-3 text-xs font-semibold text-gray-500">
                    {{ $comment->created_at->diffForHumans() }}
                </p>
                <p wire:click="$emit('deleteClicked', {{ $comment->id }})" class="text-red-200 cursor-pointer hover:text-red-600">
                    x
                </p>
            </div>
            <p class="text-gray-800">
                {{ $comment->content }}
            </p>
          </div>
          @if($comment->image)
          <img src="{{ $comment->image }}" alt="">
          @endif
      </div>
      @endforeach
      {{ $comments->links() }}
</div>

<script>
    window.livewire.on('deleteClicked', (id)=>{
        if(confirm('정말로 삭제 하시겠습니까?')) {
            window.livewire.emit('delete', id);
        }
    })
</script>
