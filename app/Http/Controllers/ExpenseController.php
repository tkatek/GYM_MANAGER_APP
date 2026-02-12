<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::query();

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('month')) {
            $date = \Carbon\Carbon::parse($request->month);
            $query->whereMonth('date', $date->month)
                  ->whereYear('date', $date->year);
        }

        $expenses = $query->orderBy('date', 'desc')->get();
        $totalAmount = $expenses->sum('amount');

        return view('expenses.index', compact('expenses', 'totalAmount'));
    }

    public function create()
    {
        return view('expenses.create');
    }




public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|in:fixed,variable,marketing,maintenance,salaries,utilities',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    \App\Models\Expense::create($request->all());

    return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully!');
}











public function edit(Expense $expense)
{
    return view('expenses.edit', compact('expense'));
}

public function update(Request $request, Expense $expense)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category' => 'required|in:fixed,variable,marketing,maintenance,salaries,utilities',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    $expense->update($request->all());

    return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
}

public function destroy(Expense $expense)
{
    $expense->delete();
    return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
}





}