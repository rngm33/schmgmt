<?php

namespace App\Http\Controllers\Manager;

use App\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Client;
use App\Kista;
use App\Detail;
use Auth;
use Response;
use Throwable;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $search = $request->search;

        $posts = Detail::orderBy('id', 'DESC')
            ->where('created_by', Auth::user()->id)
            ->where('kista_id', $kistaid);
        if (empty($request->search)) {
            $posts = $posts;
        } else {
            $search = $request->search;
            $posts = $posts->whereHas('getClientInfo', function (Builder $query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orwhere('serial_no', 'LIKE', "%{$search}%");
            });
        }
        if ($request->has('agentid') && $request->get('agentid') != "") {
            $agent_id = $request->agentid;
            $posts = $posts->whereHas('getClientInfo', function (Builder $query) use ($agent_id) {
                $query->where('agent_id', $agent_id);
            });
        }
        // if($request->has('kistaid') && $request->get('kistaid')!="")
        // {            
        //     $kista_id = $request->kistaid;
        //     $posts = $posts->whereHas('getClientInfo', function(Builder $query) use ($kista_id){
        //                       $query->where('kista_id', $kista_id);
        //                     });
        // }
        $posts = $posts->with('getClientInfo', 'getAgentInfo')->get();
        $response = [
            'kistadetails' => $posts,
        ];
        return response()->json($response);
    }



    public function detailVoucher(Request $request)
    {
        $kistaAmount = Kista::where('luckydraw_id', $request->luckydraw_id)
            ->where('id', $request->kistaid)->first()->amount;

        if ($request->type == "Agent") {
            //get agent list except Default one
            $agent = Agent::where('name', '!=', 'default')->get();
            $client = Client::where('agent_id', $agent[0]->id)->get();
            return response()->json([
                'respo' => $agent,
                'status' => true
            ]);
        }

        if ($request->type == "Default") {
            // get id of Default agent
            $defid = Agent::where('name', 'default')->first()->id;

            //get data of paid members of Default agt.
            $detail_check = Detail::where([
                ['agent_id', $defid],
                ['luckydraw_id', $request->luckydraw_id],
                ['kista_id', $request->kistaid],
                ['lottery_status', 2]
            ])
                ->with('getClientInfo')
                ->get();

            return response()->json([
                'respo' => $detail_check,
                'status' => false
            ]);
        }
    }

    public function detailVoucherDefault(Request $request)
    {
        // dd($request->all());
        $clientid = $request->clientid;
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;
        $detail = Detail::where('client_id', $clientid)
            ->where('luckydraw_id', $luckydrawid)
            ->where('kista_id', $kistaid)
            ->with('getClientInfo')->first();

        $kistaAmt = Kista::where('luckydraw_id', $luckydrawid)
            ->where('id', $kistaid)->value('amount');
        return response()->json([
            'respo' => $detail,
            'kistaamt' => $kistaAmt,
        ]);
    }

    public function detailVoucherAgent(Request $request)
    {
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;

        $agent = Agent::findOrFail($agentid);
        //count total no. of clients of particular agent
        $client = Client::where('agent_id', $agentid)->count();
        //get kista amt of particular scheme and kista
        $kistaAmt = Kista::where('luckydraw_id', $luckydrawid)
            ->where('id', $kistaid)->value('amount');

        $detail = Detail::where('luckydraw_id', $luckydrawid)
            ->where('kista_id', $kistaid)
            ->where('agent_id', $agentid)
            ->where('lottery_status', 2)->get();

        $amt = 0;
        foreach ($detail as $d) {
            $amt += $d->amount;
        }
        return response()->json([
            'agent' => $agent,
            'client' => $client,
            'kistaamt' => $kistaAmt,
            'amt2bepaid' => ($kistaAmt * $client),
            'amtpaid' => $amt,
            'dtlcount' => $detail->count()

        ]);
    }

    public function detail(Request $request)
    {
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;

        $checkDetail = Detail::where('agent_id', $agentid)->where('kista_id', $kistaid)->count();
        $checkLotteryStats = Detail::where('agent_id', $agentid)
            ->where('kista_id', $kistaid)
            ->where('lottery_status', 1)
            ->count();
        if ($checkDetail) {
            $posts = Detail::orderBy('id', 'DESC')
                ->where('agent_id', $agentid)
                ->where('kista_id', $kistaid)
                ->with('getClientInfo')
                ->get();
            $kista = '1';
            $status = true;
        } else {
            $posts = Client::orderBy('id', 'DESC')
                ->select('id', 'name', 'agent_id', 'is_leave', 'serial_no')
                ->where('agent_id', $agentid)
                ->where('is_leave', '1')
                ->get();
            $kista = Kista::where('id', $kistaid)->value('amount');
            $status = false;
        }

        $response = [
            'kistadetails' => $posts,
            'kistaAmount' => $kista,
            'status' => $status,
            'lotsts' => $checkLotteryStats
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
        // dd($request->lottery_status,$request->amount);
        // dd($request->agent_id,$request->luckydraw_id,$request->agent_id);
        $mode = $request->updateMode;
        if ($mode == "true") {
            // dd($request->all());
            $lottery_status = $request->ls;
            $payment_type = $request->pt;
            $client_id = $request->cid;
            $luckydraw_id = $request->lid;
            $kista_id = $request->kid;
            if ($lottery_status == 1) {
                $amount = 0;
            } else {
                $amount = $request->amt;
            }
            $datas = Detail::where('luckydraw_id', $luckydraw_id)
                ->where('kista_id', $kista_id)
                ->where('client_id', $client_id)->first();

            $datas->client_id = $client_id;
            $datas->lottery_status = $lottery_status;
            $datas->payment_type = $payment_type;
            $findkista = Kista::find($kista_id);
            if ($lottery_status == '1') {
                // $datas->amount = $findkista->amount;
                // $datas->remaining = '0';
                $datas->amount = '0';
                $datas->remaining = $findkista->amount;
            } elseif ($lottery_status == '2') {
                $datas->amount = $amount;
                $datas->remaining = $findkista->amount - $amount;
                if ($datas->remaining > 0) {
                    $datas->is_remained = 1;
                }
            } else {
                $datas->amount = '0';
                // $datas->amount = $findkista->amount;
                $datas->remaining = '0';
            }
            if ($datas->update()) {
                return response()->json([
                    'status' => 'success',
                    'id' => $client_id
                ]);
            }
        }
        if ($mode == "false") {
            $luckydraw_id = $request->luckydraw_id;
            $kista_id = $request->kista_id;
            $agent_id = $request->agent_id;
            $amount = $request->amount;
            $lottery_data = $request->lottery_status;
            $loop_check = $request->data;
            $payment = $request->payment_type;

            $kistaCheck = Detail::where('luckydraw_id', $luckydraw_id)
                ->where('agent_id', $agent_id)
                ->where('kista_id', $kista_id - 1)->exists();
            if ($kistaCheck == false && ($kista_id - 1) != 0) {
                return ['message' => 'kistaempty'];
            }

            foreach ($loop_check as $key => $value) {
                $counts = Detail::where('luckydraw_id', $luckydraw_id)->where('kista_id', $kista_id)->where('client_id', $value['id'])->count();
                if ($counts == '1') {
                    return ['message' => 'Data already inserted'];
                } else {
                    $datas = new Detail;
                    $datas->client_id = $value['id'];
                    $datas->luckydraw_id = $luckydraw_id;
                    $datas->kista_id = $kista_id;
                    $datas->agent_id = $agent_id;
                    $datas->lottery_status = $lottery_data[$key];
                    $datas->payment_type = $payment[$key];
                    $findkista = Kista::find($kista_id);
                    if ($lottery_data[$key] == '1') {
                        // $datas->amount = $findkista->amount;
                        // $datas->remaining = '0';
                        $datas->amount = '0';
                        $datas->remaining = $findkista->amount;
                    } elseif ($lottery_data[$key] == '2' && $amount[$key] != null) {
                        $datas->amount = $amount[$key];
                        $datas->remaining = $findkista->amount - $amount[$key];
                        if ($datas->remaining > 0) {
                            $datas->is_remained = 1;
                        }
                    } else {
                        $datas->amount = '0';
                        // $datas->amount = $findkista->amount;
                        $datas->remaining = '0';
                    }
                    $datas->date = date("Y-m-d");
                    $datas->date_np = $this->helper->date_np_con_parm(date("Y-m-d"));
                    $datas->time = date("H:i:s");
                    $datas->created_by = Auth::user()->id;
                    $datas->save();
                }
            }
        }
        // dd($count);

        return response()->json([
            'message' => 'success'
        ]);
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
        $details = Detail::findOrFail($id);
        return response()->json([
            'details' => $details
        ], 200);
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
    }
    public function prize(Request $request)
    {
        // dd($request);
        $datas = Detail::findOrFail($request->detailid);
        $datas->update([
            'lottery_prize' => $request['lottery_prize'],
            'updated_by' => Auth::user()->id,
        ]);
        return ['message' => 'Data Updated'];
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

    public function revise($id, $lotteryStatus)
    {
        $remaining = Detail::where('id', $id)->value('remaining');
        $kista_id = Detail::where('id', $id)->value('kista_id');
        // $amount = Kista::where('id',$kista_id)->value('amount');
        // dd($kista_id,$amount);
        $amount = Detail::where('id', $id)->value('amount');
        // dd($amount);
        $user = Detail::findOrFail($id);
        if ($lotteryStatus == '2') {
            $user->lottery_status = 1;
            $user->amount = $remaining;
            $user->remaining = $amount;
        } elseif ($lotteryStatus == '1') {
            $user->lottery_status = 2;
            $user->amount = $remaining;
            $user->remaining = $amount;
        }
        $user->update();
    }
}
