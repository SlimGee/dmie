<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Financials') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                <div>
                    <div class="px-4 sm:px-0">
                        <h3 class="text-base font-semibold leading-7 text-gray-900">Aanalysis Results</h3>
                        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">variables results.</p>
                    </div>
                    <div class="mt-6 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div class="py-6 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Investment Efficiency vs.
                                    Financial Reporting Quality</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <p>Co efficient: {{ $ieVsFrqCE }}</p>
                                    <p>Intercept: {{ $ieVsFrqIntercept }}</p>
                                </dd>
                            </div>
                            <div class="py-6 px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Debt Maturity vs. Financial
                                    Reporting Quality</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    <p>Co efficient: {{ $dmVsFrqCE }}</p>
                                    <p>Intercept: {{ $dmVsFrqIntercept }}</p>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
