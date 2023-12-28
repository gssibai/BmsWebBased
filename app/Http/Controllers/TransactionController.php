<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Account;
use App\Models\Transaction;
class TransactionController extends Controller
{
    public function edit($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);
        // Implement authorization checks here to ensure user can edit this transaction
        return view('transactions.edit', compact('transaction'));
    }
    function validateEntry(Request $request){
        return $request->validate([
            'amount' => 'required|decimal',
            'transaction_date' => 'required|date',
            'transaction_type' => 'required|in:deposit,withdrawal,transfer',
            'branch_id' => 'required|integer',
            'balance' => 'required|decimal',
            'account_id' => 'required|integer',
            'description' => 'nullable|string',
            'to_account_id'=>'required|integer'
        ]);
    }

    public function update(Request $request, $transactionId){
        $transaction = Transaction::findOrFail($transactionId);
        // Implement authorization checks here to ensure user can modify this transaction
        $transaction->update(TransactionController::validateEntry($request));
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully!');
    }

    public function destroy($transactionId)
    {
        // Implement strict authorization and auditing for transaction deletion
        $transaction = Transaction::findOrFail($transactionId);
        // Ensure only authorized users can delete transactions and log the deletion
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
    }

    public function create()
{
    // Pre-populate form fields with relevant data if needed (e.g., account balance)
    return view('transactions.create');
}
public function store(Request $request){
    $account = Account::findOrFail($request->account_id);
// Check for sufficient funds if it's a withdrawal or transfer
if (in_array($request->transaction_type, ['withdrawal', 'transfer']) && $account->balance < $request->amount) {
    return redirect()->back()->withErrors(['amount' => 'Insufficient funds.']);
}
// Calculate the new balance based on transaction type
$newBalance = $this->calculateNewBalance($account->balance, $request->amount, $request->transaction_type);

// Create the transaction with the calculated balance
Transaction::create([
    'amount' => $request->amount,
    'transaction_date' => now(),
    'transaction_type' => $request->transaction_type,
    'branch_id' => $request->branch_id,
    'balance' => $newBalance,
    'account_id' => $request->account_id,
    'description' => $request->description,
]);
// Update the account balance for withdrawal or deposit
if (in_array($request->transaction_type, ['withdrawal', 'deposit'])) {
    $account->update(['balance' => $newBalance]);
    return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');

}

if ($request->transaction_type === 'transfer') {
    $toAccountId = $request->get('to_account_id'); // Assuming you have a 'to_account_id' field in your form
    $toAccount = Account::findOrFail($toAccountId);

    try {
        // Start a database transaction for both accounts
        DB::beginTransaction();

        // Deduct amount from the source account
        $account->balance -= $request->amount;
        $account->save();

        // Add amount to the destination account
        $toAccount->balance += $request->amount;
        $toAccount->save();

        // Create two transactions (one for each account)
        Transaction::create([
            'amount' => $request->amount,
            'transaction_date' => now(),
            'transaction_type' => 'transfer',
            // ... other fields
            'account_id' => $request->account_id,
        ]);

        Transaction::create([
            'amount' => $request->amount,
            'transaction_date' => now(),
            'transaction_type' => 'transfer',
            // ... other fields
            'account_id' => $toAccountId,
        ]);

        DB::commit(); // Commit both changes if successful
        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');

    } catch (\Exception $e) {
        DB::rollBack(); // Rollback changes if any error occurs
        // Handle the exception and log the error
        return redirect()->back()->withErrors(['error' => 'Failed to complete transfer. Please try again.']);
    }
}
}
private function calculateNewBalance($currentBalance, $transactionAmount, $transactionType)
{
    switch ($transactionType) {
        case 'deposit':
            return $currentBalance + $transactionAmount;
        case 'withdrawal':
            return $currentBalance - $transactionAmount;
        case 'transfer':
            // Transfer logic will handle balance updates separately
            return $currentBalance;
        default:
            return $currentBalance; // Should not happen, but handle for safety
    }
}
}
