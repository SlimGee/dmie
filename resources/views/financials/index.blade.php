<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __($company->name . ' Financials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('vars.calculate', $company) }}">
                    <x-primary-button>View Analysis</x-primary-button>
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
                                                    Year
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Net Profit
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Total Assets
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Net Income
                                                </th>
                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Cash Flow form continuous ops
                                                </th>

                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    cash flow from investing activiteis
                                                </th>

                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Avg net opr assets
                                                </th>

                                                <th scope="col"
                                                    class="py-3 px-6 text-xs font-medium text-gray-500 uppercase text-start dark:text-neutral-500">
                                                    Actions
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                            @foreach ($financials as $financial)
                                                <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->year }}</td>

                                                    <td
                                                        class="py-4 px-6 text-sm font-medium text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->net_profit }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->total_assets }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->net_income }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->cash_flow_from_operations }}</td>

                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->cash_flow_from_investing_activities }}</td>

                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        {{ $financial->average_net_operating_assets }}</td>
                                                    <td
                                                        class="py-4 px-6 text-sm text-gray-800 whitespace-nowrap dark:text-neutral-200">
                                                        <a href="{{ route('financials.calculate', $financial) }}"
                                                            class="inline-flex gap-x-2 items-center text-sm font-semibold text-blue-600 rounded-lg border border-transparent dark:text-blue-500 hover:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:hover:text-blue-400">
                                                            Calculate Variables
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
