{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sources') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('sources.create') }}">
                            <x-primary-button>
                                {{ __('Add New Source') }}
                            </x-primary-button>
                        </a>
                    </div>
                    <div class="flex flex-col space-y-4 gap-4">
                        @foreach ($sources as $source)
                            <div class="flex items-center justify-between border p-4 rounded-lg shadow-sm gap-3 cursor-pointer hover:bg-gray-100" onclick="window.location.href='{{ route('sources.edit', $source) }}';">
                                <div class="overflow-hidden gap">
                                    <div class="flex gap-3 mb-2">
                                        <p class="font-semibold text-lg">{{ $source->title }}</p>
                                        <p class="bg-gray-100 text-sm text-gray-600 rounded px-2 py-1 inline-block">
                                            <span class="font-semibold">
                                                {{ __('Type:') }} 
                                            </span>
                                            <span class="font-normal">
                                                {{ $source->type }}
                                            </span>
                                        </p>
                                        <p class="bg-gray-100 text-sm text-gray-600 rounded px-2 py-1 inline-block">
                                            <span class="font-semibold">
                                                {{ __('ID:') }} 
                                            </span>
                                            <span class="font-normal">
                                                {{ $source->id }}
                                            </span>
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-600 flex gap-2">
                                        <span class="font-semibold">
                                            {{ __('Source:') }}
                                        </span>
                                        <span class="text-nowrap overflow-hidden">
                                            {{ $source->ics_url }}
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-600 flex gap-2">
                                        <span class="font-semibold">
                                            {{ __('Destination:') }}
                                        </span>
                                        <span class="text-nowrap overflow-hidden">
                                            {{ Storage::disk('public')->url($source->converted_ics_path) }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex flex-col px-4 gap-4 ms-auto">
                                    <a href="{{ route('sources.edit', $source) }}">
                                        <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                                    </a>
                                    <form action="{{ route('sources.destroy', $source) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="text-red-500">{{ __('Delete') }}</x-danger-button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>