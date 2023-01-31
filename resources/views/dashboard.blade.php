<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="bg-white max-w-7xl mx-auto p-4">
                @auth('admin')
                admin
                @else
                
                @endauth
        </div>
    </div>
</x-app-layout>
