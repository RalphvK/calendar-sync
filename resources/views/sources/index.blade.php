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
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ __('Type') }}</th>
                                <th class="px-4 py-2">{{ __('ICS URL') }}</th>
                                <th class="px-4 py-2">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sources as $source)
                                <tr>
                                    <td class="border px-4 py-2">{{ $source->type }}</td>
                                    <td class="border px-4 py-2">{{ $source->ics_url }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('sources.edit', $source) }}" class="text-blue-500">{{ __('Edit') }}</a>
                                        <form action="{{ route('sources.destroy', $source) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>