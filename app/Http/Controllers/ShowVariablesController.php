<?php

namespace App\Http\Controllers;

use App\Models\Financial;

class ShowVariablesController extends Controller
{
    public function show(Financial $financial)
    {
        $debts = $financial->company->debts()->where('year', $financial->year)->get();

        return view('variables.show', [
            'debts' => $debts,
            'financial' => $financial,
        ]);
    }
}
