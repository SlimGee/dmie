<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CalculateThings extends Controller
{
    public function calculate(Request $request)
    {
        $debtRecords = $request->input('debt_records', []);
        $investments = $request->input('investments', []);
        $earningsQuality = $request->input('earnings_quality');
        $auditQuality = $request->input('audit_quality');
        $disclosureQuality = $request->input('disclosure_quality');
        $internalControlQuality = $request->input('internal_control_quality');
        $corporateGovernanceQuality = $request->input('corporate_governance_quality');
        $equityValue = $request->input('equity_value');
        $equityCost = $request->input('equity_cost');
        $operatingProfit = $request->input('operating_profit');

        $debtRecords = $this->formatDebtRecords($debtRecords);
        $investments = $this->formatInvestments($investments);

        $debtMaturity = $this->calculateDebtMaturity($debtRecords);
        $investmentEfficiency = $this->calculateInvestmentEfficiency($investments);
        $financialReportingQuality = $this->calculateFinancialReportingQuality($earningsQuality, $auditQuality, $disclosureQuality, $internalControlQuality, $corporateGovernanceQuality);
        $wacc = $this->calculateWACC($debtRecords, $equityValue, $equityCost);
        $roce = $this->calculateROCE($operatingProfit, array_sum(array_column($debtRecords, 'amount')), $equityValue);

        return view('dashboard', compact('debtMaturity', 'investmentEfficiency', 'financialReportingQuality', 'wacc', 'roce'));
    }

    private function calculateDebtMaturity($debtRecords)
    {
        $totalDebt = 0;
        $weightedMaturitySum = 0;

        foreach ($debtRecords as $debt) {
            $amount = $debt['amount'];
            $maturityDate = Carbon::parse($debt['maturity_date']);

            $totalDebt += $amount;
            $daysToMaturity = $maturityDate->diffInDays(Carbon::now());
            $weightedMaturitySum += $amount * $daysToMaturity;
        }

        if ($totalDebt > 0) {
            return $weightedMaturitySum / $totalDebt;
        } else {
            return 0;
        }
    }

    private function formatDebtRecords($debtRecords)
    {
        return array_map(function ($record) {
            $values = explode(',', $record);

            return [
                'amount' => floatval(trim($values[0])),
                'maturity_date' => trim($values[1]),
                'interest_rate' => floatval(trim($values[2])),
            ];
        }, $debtRecords);
    }

    private function formatInvestments($investments)
    {
        return array_map(function ($investment) {
            $values = explode(',', $investment);

            return [
                'investment_amount' => floatval(trim($values[0])),
                'return_amount' => floatval(trim($values[1])),
            ];
        }, $investments);
    }

    private function calculateInvestmentEfficiency($investments)
    {
        $totalInvestment = 0;
        $totalReturn = 0;

        foreach ($investments as $investment) {
            $totalInvestment += $investment['investment_amount'];
            $totalReturn += $investment['return_amount'];
        }

        if ($totalInvestment > 0) {
            return ($totalReturn - $totalInvestment) / $totalInvestment * 100;
        } else {
            return 0;
        }
    }

    private function calculateFinancialReportingQuality($earningsQuality, $auditQuality, $disclosureQuality, $internalControlQuality, $corporateGovernanceQuality)
    {
        $factors = [$earningsQuality, $auditQuality, $disclosureQuality, $internalControlQuality, $corporateGovernanceQuality];
        $totalScore = array_sum($factors);
        $financialReportingQuality = $totalScore / count($factors);

        return $financialReportingQuality;
    }

    private function calculateWACC($debtRecords, $equityValue, $equityCost)
    {
        $totalDebt = array_sum(array_column($debtRecords, 'amount'));
        $totalValue = $totalDebt + $equityValue;

        $costOfDebt = 0;
        foreach ($debtRecords as $debt) {
            $amount = $debt['amount'];
            $interestRate = $debt['interest_rate'];
            $costOfDebt += ($amount / $totalDebt) * $interestRate;
        }

        $costOfEquity = $equityCost;
        $debtWeight = $totalDebt / $totalValue;
        $equityWeight = $equityValue / $totalValue;

        $wacc = ($debtWeight * $costOfDebt) + ($equityWeight * $costOfEquity);

        return $wacc;
    }

    private function calculateROCE($operatingProfit, $totalDebt, $equityValue)
    {
        $capitalEmployed = $totalDebt + $equityValue;
        $roce = $operatingProfit / $capitalEmployed * 100;

        return $roce;
    }
}
