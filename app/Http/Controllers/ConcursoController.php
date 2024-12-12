<?php

namespace App\Http\Controllers;
use App\Models\Customer;

use Illuminate\Http\Request;

class ConcursoController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        //order by the most points
        $customers = $customers->sortByDesc(function($customer) {
            return $customer->getTotalPoints();
        });

        return view('concurso')->with('customers', $customers);
    }

}
