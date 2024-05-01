<?php

namespace App\Service;

class CalculationService
{
    public function calculateInvestmentEfficiency($netProfit, $totalAssets)
    {
        return $netProfit / $totalAssets;
    }

    public function calculateDebtMaturity($currentDebt, $longTermDebt, $totalPrincipal)
    {
        $currentDebtMaturity = $currentDebt * 1;  // Assuming current debt maturity is 1 year
        $longTermDebtMaturity = $longTermDebt * 5;  // Assuming long-term debt average maturity is 5 years
        $weightedMaturity = ($currentDebtMaturity + $longTermDebtMaturity) / $totalPrincipal;

        return $weightedMaturity;
    }

    public function calculateFinancialReportingQuality($netIncome, $operatingCashFlow, $investingCashFlow, $averageNetOperatingAssets)
    {
        $numerator = $netIncome - $operatingCashFlow - $investingCashFlow;

        return $numerator / $averageNetOperatingAssets;
    }
}
