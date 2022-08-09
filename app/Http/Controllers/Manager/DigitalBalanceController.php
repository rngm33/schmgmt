<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\DigitalBalance;
use Illuminate\Support\Facades\Auth;

class DigitalBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DigitalBalance::orderBy('id','DESC')
        ->where('created_by', Auth::user()->id);
        // ->where('payment_type','1')
        // ->with('getVoucherInfo');
        $posts = $posts->paginate(25);
        
        $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'digitalbalances' => $posts
        ];
        return response()->json($response);
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
        
        $this->validate($request, [
            'type' => 'required',
            'wallet_name' => 'required',
            'wallet_id' => 'required',
        ]);
        DigitalBalance::create([
        
            'type' => $request['type'],
            'wallet_name' => $request['wallet_name'],
            'wallet_id' => $request['wallet_id'],
            'amount' => $request['amount'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Created'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $digitalbalances = DigitalBalance::findOrFail($id);
        return response()->json([
            'digitalbalances'=>$digitalbalances
        ],200);
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
        $this->validate($request, [
            'wallet_name' => 'required',

        ]);
        $datas = DigitalBalance::findOrFail($id);
        $datas->update([
            'type' => $request['type'],
            'wallet_name' => $request['wallet_name'],
            'wallet_id' => $request['wallet_id'],
            'amount' => $request['amount'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
            'time' => date("H:i:s"),
            'created_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
    }

    // public function cashtransfer($id){
    //     $digitalbalances = DigitalBalance::findOrFail($id);
    //     return response()->json([
    //         'digitalbalances'=>$digitalbalances
    //     ],200);
    // }

    // public function banktransfer($id){
    //     $digitalbalances = DigitalBalance::findOrFail($id);
    //     return response()->json([
    //         'digitalbalances'=>$digitalbalances
    //     ],200);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
