<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFinancialRequest;
use App\Http\Requests\UpdateFinancialRequest;
use App\Models\Company;
use App\Models\Financial;
use App\Service\CalculationService;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Company $company)
    {
        return view('financials.index', [
            'financials' => $company->financials,
            'company' => $company,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFinancialRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Financial $financial)
    {
        return view('financials.show', ['company' => $financial->company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Financial $financial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFinancialRequest $request, Financial $financial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Financial $financial)
    {
        //
    }

    public function calculate(Financial $financial, CalculationService $calculationService)
    {
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

        return to_route('financials.vars.show', $financial);
    }
}
