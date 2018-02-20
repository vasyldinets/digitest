<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TransactionController extends Controller
{


//   WEB Methods

    /**
     * Display a listing of the transactions.
     */
    public function index() {
        return view('transactions');
    }


    /**
       get transaction with pagination
     */
    public function  getTransactionsPaginateFiltered(Request $request){
        $this->validate($request, [
            'showby' => 'integer',
            'amount' => 'numeric|nullable',
            'date' => 'date_format:Y-m-d|nullable',
            'customerId' => 'integer|nullable'
        ]);
        $param = [];
        $param['sellerId'] = Auth::user()->id;
        foreach ($request->request as $key => $value){
            if ($value && ($key == 'amount' || $key == 'date' || $key == 'customerId')){
                $param[$key] = $value;
            }
        }
        $transactions = Transaction::where($param)->paginate($request->showby);
        return $transactions;
    }



//    API Methods

    /**
        Add new transaction via API
     */
    public function store(Request $request){

        $this->validate($request, [
            'customerId' => 'required|integer',
            'amount' => 'required|numeric',
        ]);

//        Check if exist customer
        $customer = Customer::where(['id' => $request->customerId])->first();
        if (!$customer){
            return abort(404,"Customer with this ID not exist");
        }
//        Check card limit
        if ($customer->cardLimit < $request->amount){
            return abort(403,"Not enough money in your card");
        }
//      Create new transaction
        $transaction = Transaction::create([
            'customerId' => intval($request->customerId),
            'sellerId' => intval(Auth::user()->id),
            'amount' => +$request->amount,
            'offset' => -$request->amount,
            'limit' => $customer->cardLimit - $request->amount,
            'date' => now()->format('Y-m-d'),
        ]);

//        If all ok, update card limit
        if ($transaction){
            $customer->cardLimit = $customer->cardLimit - $request->amount;
            $customer->save();
        }

        return $transaction;
    }


    /**
     * Display the specified resource.
     */
    public function show(Customer $customer, $transactionId) {

        $transaction = Transaction::where(['id' => $transactionId, 'customerId' => $customer->id])->first();

        if (!$transaction){
            return abort(404,"Transaction with this ID not exist");
        }

        return $transaction;
    }



    /**
     * Update the transaction in storage.
     */
    public function update(Request $request, Transaction $transaction){

        $this->validate($request, [
            'amount' => 'required|numeric',
        ]);

        $customer = Customer::where(['id' => $transaction->customerId])->first();

//        Check difference between operations
        $updateLimit = $customer->cardLimit + ($transaction->amount - $request->amount);

//      Update transaction data
        $transaction->amount = +$request->amount;
        $transaction->limit = $updateLimit;
        $transaction->offset = -$request->amount;
        $transaction->date = now()->format('Y-m-d');

        $transaction->save() ? $result = 'success' : $result = 'false';

//        Update cart limit
        if($transaction){
            $customer->cardLimit = $updateLimit;
            $customer->save();
        }

        return $transaction;
    }

    /**
     * Remove transaction resource from storage.
     */
    public function destroy(Transaction $transaction) {

        $transaction->delete() ? $result = 'success' : $result = 'false';

        return $result;
    }

    /**
     * Get filtered transactions
     */

    public function getFilteredTransactions(Request $request){

        $this->validate($request, [
            'customerId' => 'integer|nullable',
            'amount' => 'numeric|nullable',
            'offset' => 'numeric|nullable',
            'limit' => 'numeric|nullable',
            'date' => 'date_format:Y-m-d|nullable',
        ]);

        $param = [];
        foreach ($request->request as $key => $value){
            if ($value && $key != '_url'){
                $param[$key] = $value;
            }
        }
        $transactions = Transaction::where($param)->get();

        return $transactions;
    }
}
