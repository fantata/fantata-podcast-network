<div>
    <div class="flex flex-col">
        <div class='w-full'>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 text-green-400 cursor-pointer block mx-auto" wire:click="add" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
        </div>

        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($episodes as $ep)
                    <tr>
                        <td class="px-2 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $ep->title }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href='#' wire:click="edit({{$ep->id}})" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="px-2 py-4 whitespace-nowrap" colspan=2>No eps yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    @if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-70 overflow-y-auto h-full w-full" id="overlay"></div>
    <div class="fixed top-10 left-1/4 w-1/2 mx-auto">
        <div class="text-left bg-white h-auto p-8 shadow-2xl rounded-lg mx-2">

            <div>
                @if (@$successMessage)
                <div class="rounded-md bg-green-50 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm leading-5 font-medium text-green-800">
                                {{ $successMessage }}
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="enquiry = false" wire:click="$set('successMessage', null);" class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 transition ease-in-out duration-150" aria-label="Dismiss">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <x-form id="episode-form" wire:submit.prevent="store">

                    @wire
                    <x-form-input name="title" autocomplete="title" placeholder="Title" />
                    <x-form-textarea name="description" autocomplete="description" placeholder="Description" />
                    <livewire:single-upload wire:model="file" :file="$file" :episode_id="$episode_id" />
                    @endwire

                    <div class="grid grid-cols-2">
                        <div class='col'>
                            <x-form-submit class='w-full mr-1 bg-green-600 hover:bg-green-900'>Save</x-form-submit>
                        </div>
                        <div class='col'>
                            <div class="mt-6">
                                <button class="ml-1 text-center ock bg-gray-400 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" wire:click.prevent="hideModal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                </x-form>

            </div>
        </div>
    </div>
    @endif

</div>