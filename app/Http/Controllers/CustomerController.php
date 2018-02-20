<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //Add customer via API
    public function store(Request $request){

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'cardNumber' => 'required|regex:/[0-9]{16}/',
            'cardMonth' => 'required|integer|between:1,12',
            'cardYear' => 'required|integer|digits:4',
            'cardCvv' => 'required|integer|digits:3',
        ]);

//        Check expiration date
        $now = now();
        if ($request->cardYear <= $now->format('Y') && $request->cardMonth < $now->format('m')){
            return abort(403,"Expired Card");
        }
//      Check if card exist on DB
        $customer = Customer::where(['cardNumber' => $request->cardNumber])->first();

        if ($customer){
//            If exist and all data ok, update customer
            if ($customer->cardMonth == $request->cardMonth &&
                $customer->cardYear == $request->cardYear &&
                $customer->cardCvv == $request->cardCvv){

                    $customer->name = $request->name;
                    $customer->save();

            } else {
                return abort(403,"You enter wrong data! Check and try again");
            }
        }
//        Create new customer
        else{
            $customer = Customer::create([
                'name' => $request->name,
                'cardNumber' => $request->cardNumber,
                'cardMonth' => $request->cardMonth,
                'cardYear' => $request->cardYear,
                'cardCvv' => $request->cardCvv,
            ]);
        }

        return $customer->id;
    }
}
