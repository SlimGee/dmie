<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 md:w-6/12">
                    <form action="{{ route('calculate') }}" method="POST" x-data="formData()">
                        @csrf

                        <div class="mb-6">
                            <h2 class="mb-2 text-xl font-semibold">Debt Records</h2>
                            <template x-for="(debt, index) in debtRecords" :key="index">
                                <div class="flex items-center mb-2">
                                    <x-form.input type="text" x-model="debt.value" name="debt_records[]"
                                        placeholder="Amount, Maturity Date (YYYY-MM-DD), Interest Rate"
                                        class="flex-grow mr-2 form-input" />
                                    <button type="button" @click="removeDebtRecord(index)"
                                        class="btn btn-danger">Remove</button>
                                </div>
                            </template>
                            <x-secondary-button type="button" @click="addDebtRecord()" class="btn btn-primary">Add Debt
                                Record</x-secondary-button>
                        </div>

                        <div class="mb-6">
                            <h2 class="mb-2 text-xl font-semibold">Investments</h2>
                            <template x-for="(investment, index) in investments" :key="index">
                                <div class="flex items-center mb-2">
                                    <x-form.input type="text" x-model="investment.value" name="investments[]"
                                        placeholder="Investment Amount, Return Amount"
                                        class="flex-grow mr-2 form-input" />
                                    <button type="button" @click="removeInvestment(index)"
                                        class="btn btn-danger">Remove</button>
                                </div>
                            </template>
                            <x-secondary-button type="button" @click="addInvestment()" class="btn btn-primary">Add
                                Investment</x-secondary-button>
                        </div>

                        <div class="mb-6">
                            <h2 class="mb-2 text-xl font-semibold">Financial Reporting Quality</h2>
                            <div class="mb-2">
                                <label for="earnings_quality" class="block text-sm font-medium text-gray-700">Earnings
                                    Quality</label>
                                <x-form.input id="earnings_quality" type="number" name="earnings_quality"
                                    min="1" max="5" required x-model="earningsQuality"
                                    class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="audit_quality" class="block text-sm font-medium text-gray-700">Audit
                                    Quality</label>
                                <x-form.input id="audit_quality" type="number" name="audit_quality" min="1"
                                    max="5" required x-model="auditQuality" class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="disclosure_quality"
                                    class="block text-sm font-medium text-gray-700">Disclosure Quality</label>
                                <x-form.input id="disclosure_quality" type="number" name="disclosure_quality"
                                    min="1" max="5" required x-model="disclosureQuality"
                                    class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="internal_control_quality"
                                    class="block text-sm font-medium text-gray-700">Internal Control Quality</label>
                                <x-form.input id="internal_control_quality" type="number"
                                    name="internal_control_quality" min="1" max="5" required
                                    x-model="internalControlQuality" class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="corporate_governance_quality"
                                    class="block text-sm font-medium text-gray-700">Corporate Governance Quality</label>
                                <x-form.input id="corporate_governance_quality" type="number"
                                    name="corporate_governance_quality" min="1" max="5" required
                                    x-model="corporateGovernanceQuality" class="mt-1 w-full form-input" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <h2 class="mb-2 text-xl font-semibold">Other Financial Data</h2>
                            <div class="mb-2">
                                <label for="equity_value" class="block text-sm font-medium text-gray-700">Equity
                                    Value</label>
                                <x-form.input id="equity_value" type="number" name="equity_value" required
                                    x-model="equityValue" class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="equity_cost" class="block text-sm font-medium text-gray-700">Equity
                                    Cost</label>
                                <x-form.input id="equity_cost" type="number" name="equity_cost" required
                                    x-model="equityCost" class="mt-1 w-full form-input" />
                            </div>
                            <div class="mb-2">
                                <label for="operating_profit"
                                    class="block text-sm font-medium text-gray-700">Operating Profit</label>
                                <x-form.input id="operating_profit" type="number" name="operating_profit" required
                                    x-model="operatingProfit" class="mt-1 w-full form-input" />
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-button type="submit" class="btn btn-primary">Calculate</x-button>
                        </div>
                    </form>

                    @if (isset($debtMaturity) &&
                            isset($investmentEfficiency) &&
                            isset($financialReportingQuality) &&
                            isset($wacc) &&
                            isset($roce))
                        <div class="mt-8">
                            <h2 class="mb-2 text-xl font-semibold">Results</h2>
                            <div class="mb-2">
                                <span class="font-semibold">Debt Maturity:</span> {{ $debtMaturity }} days
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Investment Efficiency:</span> {{ $investmentEfficiency }}%
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Financial Reporting Quality:</span>
                                {{ $financialReportingQuality }} (out of 5)
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Weighted Average Cost of Capital (WACC):</span>
                                {{ $wacc }}%
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Return on Capital Employed (ROCE):</span>
                                {{ $roce }}%
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        function formData() {
            return {
                debtRecords: [],
                investments: [],
                earningsQuality: 1,
                auditQuality: 1,
                disclosureQuality: 1,
                internalControlQuality: 1,
                corporateGovernanceQuality: 1,
                equityValue: null,
                equityCost: null,
                operatingProfit: null,

                addDebtRecord() {
                    this.debtRecords.push({
                        value: ''
                    });
                },

                removeDebtRecord(index) {
                    this.debtRecords.splice(index, 1);
                },

                addInvestment() {
                    this.investments.push({
                        value: ''
                    });
                },

                removeInvestment(index) {
                    this.investments.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>
