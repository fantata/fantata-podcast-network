<div>
    <div class="flex mt-4 justify-center items-center" x-data="dropfile()">
        <div class="py-6 w-96 rounded border-dashed border-2 flex flex-col justify-center items-center" x-bind:class="droppingFile ? 'bg-gray-400 border-gray-500' : 'border-gray-500 bg-gray-200'" x-on:drop="droppingFile = false" wire:drop.prevent="$emit('file-dropped', $event)" x-on:dragover.prevent="droppingFile = true" x-on:dragleave.prevent="droppingFile = false">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
            </svg>
            <div class="text-center" wire:loading wire.target="files">File uploading...</div>
            @if($uploaded)
            <div>File uploaded</div>
            @else
            <div class="text-center" wire:loading.remove wire.target="files">Drop Episode mp3 here</div>
            @endif
        </div>
    </div>

    <script>
        window.dropfile = function() {
            return {
                droppingFile: false
            }
        }

        window.livewire.on('file-dropped', (event) => {
            let files = event.dataTransfer.files;
            let fileObject = files[0];
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('newFile', reader.result)
            }
            reader.readAsDataURL(fileObject);
        })
    </script>
</div>