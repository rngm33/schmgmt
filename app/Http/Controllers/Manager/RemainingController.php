<?php

namespace App\Http\Controllers\Manager;

use App\ClientPaidDue;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use Auth;
use Response;

class RemainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Detail::where('is_remained','1')
                        ->where('created_by', Auth::user()->id)
                        ->where('rpaid_date',Null)
                        ->with('getClientInfo','getKistaInfo','getAgentInfo','getLuckydrawInfo')
                        ->get();
                        // dd($posts);
        $response = [
            'remainings' => $posts
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
        $amount = $request->amount;
        $detail_id = $request->detail_id;
        $data_id = Detail::where('id',$detail_id)
                        ->value('id');
        $data_amount = Detail::where('id',$detail_id)
                        ->value('amount');
        $remaining = Detail::where('id', $detail_id)
                            ->value('remaining');

        if($amount == $remaining){
            $total_amount = $data_amount + $amount;
            $datas = Detail::findOrFail($data_id);
            $datas->update([
                'amount' => $total_amount,
                'remaining' => $remaining-$amount,
                'rpaid_date' => date("Y-m-d"),
                'rpaid_date_np' => date("Y-m-d"),
            ]);

            $clientpaydue = new ClientPaidDue();
            $clientpaydue->client_id = $datas->client_id;
            // $clientpaydue->detail_id = $datas->id;
            $clientpaydue->luckydraw_id = $datas->luckydraw_id;
            $clientpaydue->kista_id = $datas->kista_id;
            $clientpaydue->agent_id = $datas->agent_id;
            $clientpaydue->lottery_status = 2;
            $clientpaydue->payment_type = $datas->payment_type;
            $clientpaydue->amount = $remaining;
            $clientpaydue->remaining = $remaining - $amount;
            $clientpaydue->rpaid_date =  date("Y-m-d");
            $clientpaydue->rpaid_date_np = date("Y-m-d");
            $clientpaydue->date_np = $datas->date_np;
            $clientpaydue->date = $datas->date;
            $clientpaydue->time = $datas->time;
            $clientpaydue->is_active = $datas->is_active;
            $clientpaydue->is_remained = $datas->is_remained;
            $clientpaydue->created_by = $datas->created_by;
            $clientpaydue->save();
            return ['message' => 'Data Updated'];

        }                    

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
        //
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
        //
    }

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
