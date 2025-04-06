<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Source') }}
        </h2>
    </x-slot>

    <section class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Add a New ICS Source') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Provide the details of the ICS source you want to add to your calendar.') }}
            </p>
        </header>

        <div class="bg-white shadow sm:rounded-lg p-6">
            @include('sources.partials.form', [
                'action' => route('sources.store'),
                'buttonText' => 'Save'
            ])
        </div>
    </section>
</x-app-layout>