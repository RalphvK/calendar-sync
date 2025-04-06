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
                    <div class="space-y-4">
                        @foreach ($sources as $source)
                            <div class="flex items-center justify-between border p-4 rounded-lg shadow-sm">
                                <div class="overflow-hidden">
                                    <p class="font-semibold">{{ __('Type:') }} {{ $source->type }}</p>
                                    <p class="text-sm text-gray-600 break-all">{{ $source->ics_url }}</p>
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