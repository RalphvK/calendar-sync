{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Source') }}
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @include('sources.partials.form', ['action' => route('sources.update', $source), 'method' => 'PUT'])
                </div>
            </div>
        </div>
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <label for="converted_url" class="block text-sm font-medium text-gray-700">{{ __('Converted URL') }}</label>
                        <input type="text" id="converted_url" value="{{ $source->converted_ics_path ? Storage::disk('public')->url($source->converted_ics_path) : '' }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 cursor-pointer" onclick="copyToClipboard(this)">
                        <p id="copy-feedback" class="text-sm text-green-500 hidden mt-1">{{ __('Copied to clipboard!') }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="last_converted" class="block text-sm font-medium text-gray-700">{{ __('Last Converted') }}</label>
                        <input type="text" id="last_converted" value="{{ $source->last_converted ? \Illuminate\Support\Carbon::parse($source->last_converted)->format('d-m-Y H:i') : __('Never') }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600">
                    </div>
                    <div class="flex justify-end">
                        <form action="{{ route('sources.convert', $source) }}" method="POST">
                            @csrf
                            <x-primary-button>
                                {{ __('Convert ICS File') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>