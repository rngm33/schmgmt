<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Detail;
use App\Client;
use App\Kista;
use App\LuckyDraw;
use App\Agent;
use Auth;
use Response;
use App\Exports\Manager\MemberExport;
use App\Imports\Manager\MemberImport;
use App\Voucher;
use Maatwebsite\Excel\Facades\Excel;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;
        // dd($request->all());
        if ($request->type == "Default") {
            // get id of Default agent
            $defid = Agent::where('name', 'default')->first()->id;
            $respo = Client::where('agent_id', $defid)->get();
            $status = false;
        }

        if ($request->type == "Agent") {
            $status = true;
            // $data=[];
            // foreach($respo as $key=>$agentlist){
            // $data[$key]= Voucher::where('agent_id',$agentlist->id)
            $respo = Agent::where('name', '!=', 'default')
            // ->where('luckydraw_id', $luckydrawid)
            // ->where('kista_id', $kistaid)
            // ->with('getAgentDetail')
            ->get();
            // }
            // $respo=Voucher::where('agent_id',)->get();

        }
        return response()->json([
            'respo' => $respo,
            'status' => $status,
        
        ]);
    }

    public function getVoucherReport(Request $request)
    {
        // dd($request->all());
        $clientid = $request->clientid;
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;

        $defid = Agent::where('name', 'default')->first()->id;
        $lname=LuckyDraw::where('id', $luckydrawid)->value('name');
        $kista_name = Kista::where('id',$kistaid)->value('name');

        if (($agentid == "null" && $clientid)) {
            $voucher = Voucher::where([
                ['agent_id', $defid],
                ['luckydraw_id', $luckydrawid],
                ['kista_id', $kistaid],
                ['client_id', $clientid]
            ])->with('getKistaDetail','getClientDetail')->get();
            // $currword = [];
            // foreach ($voucher as $key => $v) {
            //     $currword[$key] = $this->convertNo($v->amount_paid);
            // }
            // ->get();
            return response()->json([
                'respo' => $voucher,
                'status' => false,
                'luckydraw_name' =>$lname,
                'kista_name' =>$kista_name
            ]);
        }
        if ($clientid == "null" && $agentid) {
            // dd($this->convertNo(1234));
            $voucher = Voucher::where([
                ['agent_id', $agentid],
                ['luckydraw_id', $luckydrawid],
                ['kista_id', $kistaid]
            ])->with('getAgentDetail','getKistaDetail')->get();
            // $vccount = $voucher->value('amount_paid');
            // dd($vccount);
            // $voucher=$voucher->with('getAgentDetail','getKistaDetail')->get();
            return response()->json([
                'respo' => $voucher,
                'status' => true,
                'luckydraw_name' =>$lname,
                'kista_name' =>$kista_name

            ]);
        }
    }

    
}
