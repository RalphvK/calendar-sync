{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/partials/form.blade.php --}}
<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-4">
        <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
        <input type="text" name="type" id="type" value="{{ old('type', $source->type ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="mb-4">
        <label for="ics_url" class="block text-sm font-medium text-gray-700">{{ __('ICS URL') }}</label>
        <input type="url" name="ics_url" id="ics_url" value="{{ old('ics_url', $source->ics_url ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="flex justify-end">
        <x-primary-button>
            {{ __('Save') }}
        </x-primary-button>
    </div>
</form>