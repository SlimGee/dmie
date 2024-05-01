<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CalculateThings;
use App\Http\Controllers\CalculateVariablesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowVariablesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return to_route('companies.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('companies.financials', FinancialController::class)->shallow();
    Route::resource('companies.debts', DebtController::class)->shallow();

    Route::get('/financials/{financial}/calculate', [FinancialController::class, 'calculate'])->name('financials.calculate');
    Route::get('/financials/{financial}/vars', [ShowVariablesController::class, 'show'])->name('financials.vars.show');
    Route::get('/analysis', [AnalysisController::class, 'show'])->name('analysis.show');
    Route::get('/calculate', [AnalysisController::class, 'calculateVariables'])->name('calculate');

    Route::get('/companies/{company}/analysis', [
        CompanyController::class,
        'analysis',
    ])->name('companies.analysis.show');

    Route::get('/vars/{company}/calculate', [CalculateVariablesController::class, 'calculate'])->name('vars.calculate');

    Route::post('/calculate', [CalculateThings::class, 'calculate'])->name('calculate');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
