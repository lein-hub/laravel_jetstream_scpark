<div class="m-2">
  {{-- component --}}
  <div class="flex flex-col px-6 py-5 bg-gray-50">
    <p class="mb-2 font-semibold text-gray-700">Bots Message</p>
    <textarea
      wire:model='newComment'
      type="text"
      name=""
      placeholder="Type message..."
      class="p-5 mb-5 bg-white border border-gray-200 rounded shadow-sm h-36"
      id=""
    ></textarea>

    <hr />

    <div class="flex flex-row items-center justify-between p-5 bg-white border border-gray-200 rounded shadow-sm">
      @if($image)
      <img class="w-10 h-10 mr-3 rounded-full" src="{{ $image->temporaryUrl() }}">
      @elseif ($orgComment->image)
        <img class="w-10 h-10 mr-3 rounded-full" src="{{ $orgComment->image_path }}">
      @endif
      <input type="file" wire:model="image" wire:loading.attr="disabled">
      <div wire:loading wire:target="image">Uploading...</div>
    </div>
    <div class="flex flex-row justify-between items-center pt-5">
      <button class="px-4 py-2 font-semibold text-white bg-green-500 rounded" wire:click="$emit('closeModal')">Cancel</button>
      <button class="px-4 py-2 font-semibold text-white bg-blue-500 rounded" wire:click="$emit('update')">Save</button>
    </div>
  </div>
</div>
