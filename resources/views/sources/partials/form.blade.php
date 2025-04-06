{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/partials/form.blade.php --}}
<form action="{{ $action }}" method="POST">
    @csrf
    @if($method ?? false)
        @method($method)
    @endif
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <input type="text" name="type" id="type" class="form-control" value="{{ $source->type ?? 'ics' }}" readonly>
    </div>
    <div class="mb-3">
        <label for="ics_url" class="form-label">ICS URL</label>
        <input type="url" name="ics_url" id="ics_url" class="form-control" value="{{ $source->ics_url ?? '' }}" required>
    </div>
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
</form>