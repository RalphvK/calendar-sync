{{-- filepath: /Users/Ralph/repos/projects/calendar-sync/resources/views/sources/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Sources') }}
        </h2>
    </x-slot>

    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Manage Your ICS Sources') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('View, edit, or delete your ICS sources below.') }}
            </p>
        </header>

        <div class="bg-white shadow sm:rounded-lg p-6">
            <a href="{{ route('sources.create') }}" class="btn btn-primary mb-3">Add New Source</a>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2">Type</th>
                        <th class="border-b py-2">ICS URL</th>
                        <th class="border-b py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sources as $source)
                        <tr>
                            <td class="border-b py-2">{{ $source->type }}</td>
                            <td class="border-b py-2">{{ $source->ics_url }}</td>
                            <td class="border-b py-2">
                                <a href="{{ route('sources.edit', $source) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('sources.destroy', $source) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>