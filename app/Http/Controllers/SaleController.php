<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:sale-list|sale-create|sale-edit|sale-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sale-create', ['only' => ['create','store']]);
        $this->middleware('permission:sale-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sale-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::latest()->where('customer_id',Auth::user()->customer_id)->paginate(5);
        return view('sales.index',compact('sales'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'amount' => 'required',
        ]);
        $request->customer_id = Auth::user()->customer_id;

        Sale::create($request->all());

        return redirect()->route('sales.index')
            ->with('success','Sale created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        return view('sale.show',compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        return view('sales.edit',compact('sales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        request()->validate([
            'name' => 'required',
            'amount' => 'required',
        ]);

        $sale->update($request->all());

        return redirect()->route('sales.index')
            ->with('success','Sale updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sale.index')
            ->with('success','Product deleted successfully');
    }
}
