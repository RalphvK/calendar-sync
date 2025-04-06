{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Source') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('sources.partials.form', ['action' => route('sources.update', $source), 'method' => 'PUT'])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>