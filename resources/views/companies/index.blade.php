<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('companies.create') }}">
                    <x-primary-button>Create Company</x-primary-button>
                </a>
                <a href="{{ route('calculate') }}">
                    <x-primary-button>View Overall Analysis</x-primary-button>
                </a>

            </div>
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div class="">
                    <div class="flex flex-col">
                        <div class="overflow-x-auto -m-1.5">
                            <div class="inline-block p-1.5 min-w-full align-middle">
                                <div class="overflow-hidden">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                        <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Name
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Records
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Address</th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-end dark:text-neutral-500">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                            @foreach ($companies as $company)
                                                <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $company->name }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        45</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $company->address }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm font-medium whitespace-nowrap text-end">
                                                        <a href="{{ route('companies.financials.index', $company) }}"
                                                            class="inline-flex gap-x-2 items-center text-sm font-semibold text-blue-600 rounded-lg border border-transparent dark:text-blue-500 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-400">
                                                            View Financials
                                                        </a>
                                                        <a href="{{ route('companies.edit', $company) }}"
                                                            class="inline-flex gap-x-2 items-center text-sm font-semibold text-blue-600 rounded-lg border border-transparent dark:text-blue-500 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-400">
                                                            Edit
                                                        </a>

                                                        <a href="{{ route('companies.destroy', $company) }}"
                                                            type="button" data-turbo-method="delete"
                                                            data-turbo-confirm="Are you sure?"
                                                            class="inline-flex gap-x-2 items-center text-sm font-semibold text-blue-600 rounded-lg border border-transparent dark:text-blue-500 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-400">
                                                            Delete
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
