<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:config-list|config-create|config-edit|config-delete', ['only' => ['index','show']]);
        $this->middleware('permission:config-create', ['only' => ['create','store']]);
        $this->middleware('permission:config-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:config-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $configs= Config::latest()->where('customer_id',Auth::user()->customer_id)->paginate(5);
        return view('configs.index',compact('configs'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configs.create');
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
            'target' => 'required',
            'customer_id' => 'required',
        ]);
        $request->customer_id = Auth::user()->customer_id;

        Config::create($request->all());

        return redirect()->route('configs.index')
            ->with('success','Config created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Config $config)
    {
        return view('configs.show',compact('config'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Config $config)
    {
        return view('configs.edit',compact('sales'));
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
            'target' => 'required',
            'customer_id' => 'required',
        ]);

        $sale->update($request->all());

        return redirect()->route('config.index')
            ->with('success','Config updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Config $config)
    {
        $config->delete();

        return redirect()->route('config.index')
            ->with('success','Config deleted successfully');
    }
}
