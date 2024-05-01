<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Debt;
use App\Models\Financial;
use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        //
        $companyFolders = File::directories(database_path('data'));

        Company::all()->each->delete();
        foreach ($companyFolders as $companyFolder) {
            // Get the company name from the folder name
            $companyName = basename($companyFolder);

            $company = Company::firstOrCreate([
                'name' => stripslashes($companyName),
                'address' => '123 NotAReal St.',
            ]);

            $incomeStatementData = json_decode(File::get($companyFolder . '/income_statement.json'), true);
            $cashFlowData = json_decode(File::get($companyFolder . '/cash_flow.json'), true);
            $balanceSheetData = json_decode(File::get($companyFolder . '/balance_sheet.json'), true);
            foreach ($balanceSheetData as $year => $balanceSheetDataForYear) {
                $netProfit = $incomeStatementData[$year]['Net Income'] ?? null;
                $totalAssets = $balanceSheetData[$year]['Total Assets'] ?? null;
                $netIncome = $incomeStatementData[$year]['Net Income'] ?? null;
                $cashFlowFromOperations = $cashFlowData[$year]['Operating Cash Flow'] ?? null;
                $cashFlowFromInvestingActivities = $cashFlowData[$year]['Investing Cash Flow'] ?? null;
                $averageNetOperatingAssets = $balanceSheetData[$year]['Total Assets'] - $balanceSheetData[$year]['Cash And Cash Equivalents'] ?? null;

                $financial = new Financial([
                    'company_id' => $company->id,
                    'net_profit' => $netProfit,
                    'total_assets' => $totalAssets,
                    'net_income' => $netIncome,
                    'cash_flow_from_operations' => $cashFlowFromOperations,
                    'cash_flow_from_investing_activities' => $cashFlowFromInvestingActivities,
                    'average_net_operating_assets' => $averageNetOperatingAssets,
                    'year' => $year,
                ]);
                $company->financials()->save($financial);

                $currentDebt = $balanceSheetData[$year]['Current Debt'] ?? 0;
                $longTermDebt = $balanceSheetData[$year]['Long Term Debt'] ?? 0;

                $debt1 = new Debt([
                    'company_id' => $company->id,
                    'principal' => $currentDebt,
                    'interest' => 0,
                    'year' => $year,  // Add this line
                    'maturity_in_months' => 12,
                ]);
                $company->debts()->save($debt1);

                $debt2 = Debt::create([
                    'company_id' => $company->id,
                    'principal' => $longTermDebt,
                    'interest' => 0,
                    'maturity_in_months' => 60,
                    'year' => $year,  // Add this line
                ]);
                $company->debts()->save($debt2);
            }
        }
    }
}
