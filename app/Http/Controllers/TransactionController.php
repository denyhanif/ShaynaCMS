<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class TransactionController extends Controller
{
   
    public function __construct(){
        $this->middleware('auth');
    }
    public function index()
    {
        $items= Transaction::all();

        return view('pages.transaction.index')->with([
            'items'=>$items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Transaction::with('details.product')//relasi details mengandung product
                            ->findOrFail($id);
        // dd('$item');
        return view('pages.transaction.show')
            ->with([
            'item'=>$item
        ]);
    }

    
    public function edit($id)
    {
        $item = Transaction::findOrFail($id);
        return view('pages.transaction.edit')->with([
            'item'=> $item
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();//ambil semua data
       
        $item = Transaction::findOrFail($id);
        $item->update($data);
        return redirect()->route('transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item= Transaction::findOrFail($id);
        
        $item->delete();
        return redirect()->route('transaction.index');
    }

    public function setStatus(Request $request,$id){
        $request->validate([
            'status'=>'required|in:PENDING,SUCCESS,FAILED'
        ]);

        $item = Transaction::findOrFail($id);
        $item->transaction_status= $request->status;

        $item->save();
        return redirect()->route('transaction.index');
    }
}
