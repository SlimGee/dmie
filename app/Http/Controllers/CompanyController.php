<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Phpml\Regression\LeastSquares;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('companies.index', ['companies' => Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    public function analysis(Company $company)
    {
        $financials = $company->financials;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        $company = Company::create($request->validated());

        return to_route('companies.index')->with('success', 'Company successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('companies.show', ['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', ['company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return to_route('companies.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return to_route('companies.index')->with('success', 'Company deleted successfully');
    }
}
