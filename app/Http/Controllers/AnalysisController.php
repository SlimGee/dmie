<?php

namespace App\Http\Controllers;

use App\Models\Financial;
use App\Service\CalculationService;
use Phpml\Regression\LeastSquares;

class AnalysisController extends Controller
{
    public function calculateVariables(CalculationService $calculationService)
    {
        $financials = Financial::all();

        foreach ($financials as $financial) {
            $financial->investment_efficiency = $calculationService->calculateInvestmentEfficiency(
                $financial->net_profit,
                $financial->total_assets
            );

            $totalPrincipal = $financial->company->debts->where('year', $financial->year)->map(function ($b) {
                $b->principal = (float) $b->principal;

                return $b;
            })->filter(fn($b) => $b->principal !== 0)->sum('principal');

            if ($totalPrincipal == 0) {
                continue;
            }

            $debtMaturity = $calculationService->calculateDebtMaturity(
                $financial->company->debts->where('year', $financial->year)->where('maturity_in_months', 12)->sum('principal'),
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

        return to_route('analysis.show');
    }

    public function show()
    {
        $financials = Financial::all();

        $investmentEfficiencies = $financials->pluck('investment_efficiency')->filter()->toArray();
        $debtMaturities = $financials->pluck('debt_maturity')->filter()->toArray();
        $financialReportingQualities = $financials->pluck('reporting_quality')->map(fn($v) => (float) $v)->filter()->toArray();

        $debtMaturities = array_values(array_map(function ($val) {
            return [(float) $val];
        }, array_values($debtMaturities)));

        $investmentEfficiencies = array_values(array_map(function ($val) {
            return [(float) $val];
        }, array_values($investmentEfficiencies)));

        $regression = new LeastSquares();
        $regression->train($investmentEfficiencies, array_values($financialReportingQualities));
        $ieVsFrqCE = $regression->getCoefficients()[0];
        $ieVsFrqIntercept = $regression->getIntercept();

        $regression = new LeastSquares();
        $regression->train($debtMaturities, array_values($financialReportingQualities));
        $dmVsFrqCE = $regression->getCoefficients()[0];
        $dmVsFrqIntercept = $regression->getIntercept();

        return view('analysis.results', compact(
            'ieVsFrqCE',
            'ieVsFrqIntercept',
            'dmVsFrqCE',
            'dmVsFrqIntercept',
        ));
    }
}
