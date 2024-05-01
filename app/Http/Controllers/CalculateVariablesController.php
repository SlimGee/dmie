<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Service\CalculationService;

class CalculateVariablesController extends Controller
{
    public function calculate(Company $company, CalculationService $calculationService)
    {
        $financials = $company->financials;

        foreach ($financials as $financial) {
            $financial->investment_efficiency = $calculationService->calculateInvestmentEfficiency(
                $financial->net_profit,
                $financial->total_assets
            );

            $totalPrincipal = $financial->company->debts->sum('principal');
            $debtMaturity = $calculationService->calculateDebtMaturity(
                $financial->company->debts->where('year', $financial->year)->where('maturity_in_months', 11)->sum('principal'),
                $financial->company->debts->where('year', $financial->year)->where('maturity_in_months', 60)->sum('principal'),
                $totalPrincipal
            );
            $financial->debt_maturity = $debtMaturity;

            $financial->reporting_quality = $calculationService->calculateFinancialReportingQuality(
                $financial->net_income,
                $financial->cash_flow_from_operations,
                $financial->cash_flow_from_investing_activities,
                $financial->average_net_operating_assets
            );

            $financial->save();
        }

        return to_route('companies.analysis.show', [
            'company' => $company,
        ]);
    }
}
