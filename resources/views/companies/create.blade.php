<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">

                <div class="max-w-xl">
                    <form method="post" action="{{ route('companies.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div class="mb-3">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-form.input id="name" name="name" type="text" class="block mt-1 w-full"
                                required autofocus autocomplete="name" />
                        </div>

                        <div class="mb-3">
                            <x-input-label for="address" :value="__('Address')" />
                            <x-form.input id="address" name="address" type="text" class="block mt-1 w-full"
                                required autocomplete="address" />
                        </div>

                        <div>
                            <x-input-label for="summary" :value="__('Summary')" />
                            <x-form.textarea id="summary" name="description" type="text"
                                class="block mt-1 w-full">{{ old('description') }}</x-form.textarea>
                        </div>

                        <div>
                            <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
