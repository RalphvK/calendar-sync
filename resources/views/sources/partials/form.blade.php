{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/partials/form.blade.php --}}
<form action="{{ $action }}" method="POST">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" value="{{ old('title', $source->title ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg">
    </div>

    <div class="mb-4">
        <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
        <select name="type" id="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="ics" {{ old('type', $source->type ?? '') === 'ics' ? 'selected' : '' }}>
                {{ __('.ics URL') }}
            </option>
        </select>
    </div>

    <div class="mb-4">
        <label for="ics_url" class="block text-sm font-medium text-gray-700">{{ __('ICS URL') }}</label>
        <input type="url" name="ics_url" id="ics_url" value="{{ old('ics_url', $source->ics_url ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    @if (isset($source))
        <div class="mb-4">
            <label for="converted_url" class="block text-sm font-medium text-gray-700">{{ __('Converted URL') }}</label>
            <input type="text" id="converted_url" value="{{ $source->converted_ics_path ? Storage::disk('public')->url($source->converted_ics_path) : '' }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600 cursor-pointer" onclick="copyToClipboard(this)">
            <p id="copy-feedback" class="text-sm text-green-500 hidden mt-1">{{ __('Copied to clipboard!') }}</p>
        </div>
        <div class="mb-4">
            <label for="last_converted" class="block text-sm font-medium text-gray-700">{{ __('Last Converted') }}</label>
            <input type="text" id="last_converted" value="{{ $source->last_converted ? \Illuminate\Support\Carbon::parse($source->last_converted)->format('d-m-Y H:i') : __('Never') }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100 text-gray-600">
        </div>
    @endif

    <div class="flex justify-end">
        <x-primary-button>
            {{ __('Save') }}
        </x-primary-button>
    </div>
</form>

<script>
    function copyToClipboard(inputElement) {
        navigator.clipboard.writeText(inputElement.value).then(() => {
            const feedback = document.getElementById('copy-feedback');
            feedback.classList.remove('hidden');
            setTimeout(() => feedback.classList.add('hidden'), 2000); // Hide feedback after 2 seconds
        }).catch(err => {
            console.error('Failed to copy text: ', err);
        });
    }
</script>