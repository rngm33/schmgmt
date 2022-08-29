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
            $defid = Agent::where('created_by',Auth::user()->id)
            ->where('name', 'default')->first()->id;
            $respo = Client::where('agent_id', $defid)->get();
            $status = false;
        }

        if ($request->type == "Agent") {
            $status = true;
            // $data=[];
            // foreach($respo as $key=>$agentlist){
            // $data[$key]= Voucher::where('agent_id',$agentlist->id)
            $respo = Agent::where('created_by',Auth::user()->id)
            ->where('name', '!=', 'default')
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

    
    // Report->VoucherController
// ---------------------------------------------------------------------------------
 public function getPaymentReport(Request $request)
 {
     // dd($request->all());
     $paymentid = $request->paymentid;
     $type = $request->type;
     $kistaid = $request->kistaid;
     $luckydrawid = $request->luckydrawid;
     $luckydraw_name=LuckyDraw::where('id',$luckydrawid)->first()->name;
     $kista_name=Kista::where('id',$kistaid)->first()->name;
     $defid = Agent::where('created_by',Auth::user()->id)
     ->where('name', 'default')->first()->id;

     $ag_amt = Detail::where('agent_id', '!=', $defid)
     ->where('luckydraw_id',$luckydrawid)
     ->where('kista_id',$kistaid)->get();
     $def_amt = Detail::where('agent_id', '=', $defid)
         ->where('luckydraw_id',$luckydrawid)
         ->where('kista_id',$kistaid)->get();
             if($type==null || $type=='Select Type'){
                 if($paymentid==null){
                     $wallet_amt_ag= $ag_amt->where('payment_type',1)->sum('amount');
                     $bank_amt_ag= $ag_amt->where('payment_type',2)->sum('amount');
                     $cash_amt_ag= $ag_amt->where('payment_type',3)->sum('amount');

                     $wallet_amt_def= $def_amt->where('payment_type',1)->sum('amount');
                     $bank_amt_def= $def_amt->where('payment_type',2)->sum('amount');
                     $cash_amt_def= $def_amt->where('payment_type',3)->sum('amount');


                     $tot_wallet=$wallet_amt_ag + $wallet_amt_def;
                     $tot_bank= $bank_amt_ag + $bank_amt_def;
                     $tot_cash=$cash_amt_ag + $cash_amt_def;

                     $amt_ag=[$tot_wallet,$tot_bank,$tot_cash];
                     // $amt_def=[$wallet_amt_def,$bank_amt_def,$cash_amt_def];

                     $gtotal=$amt_ag[0]+$amt_ag[1]+$amt_ag[2];
                     // $gtotal_def=$amt_def[0]+$amt_def[1]+$amt_def[2];

                     return response()->json([
                         'respo' => $amt_ag,
                         // 'respodef' => $amt_def,
                         'status' => true,
                         'agsts' =>true,
                         'gtotal' => $gtotal,
                         // 'gtotaldef' => $gtotal_def,
                         'ptype' => null,
                         'atype' => $type,
                         'luckydraw_name' => $luckydraw_name,
                         'kista_name' => $kista_name,
                     ]);
                 }
                 else{
                     $amt_ag= $ag_amt->where('payment_type','=',$paymentid)->sum('amount');
                     $amt_def= $def_amt->where('payment_type','=',$paymentid)->sum('amount');

                     return response()->json([
                         'respo' => $amt_ag + $amt_def,
                         // 'respodef' => $amt_def,
                         'status' => false,
                         'agsts' =>true,
                         'atype' => $type,
                         'ptype' => $paymentid,
                         'luckydraw_name' => $luckydraw_name,
                         'kista_name' => $kista_name,
                     ]);
                 }  
             }

                     if ($type == "Agent") {

                         if($paymentid==null){
                             $wallet_amt= $ag_amt->where('payment_type',1)->sum('amount');
                             $bank_amt= $ag_amt->where('payment_type',2)->sum('amount');
                             $cash_amt= $ag_amt->where('payment_type',3)->sum('amount');
                 
                             $amt=[$wallet_amt,$bank_amt,$cash_amt];
                             $gtotal=$amt[0]+$amt[1]+$amt[2];
                             return response()->json([
                                 'respo' => $amt,
                                 'status' => true,
                                 'agsts' =>false,
                                 'gtotal' => $gtotal,
                                 'ptype' => null,
                                 'atype' => $type,
                                 'luckydraw_name' => $luckydraw_name,
                                 'kista_name' => $kista_name,
                             ]);
                         }
                     else{
                         $amt= $ag_amt->where('payment_type','=',$paymentid)->sum('amount');
                         return response()->json([
                             'respo' => $amt,
                             'status' => false,
                             'agsts' =>false,
                             'atype' => $type,
                             'ptype' => $paymentid,
                             'luckydraw_name' => $luckydraw_name,
                             'kista_name' => $kista_name,
                         ]);
                     }  
                     }

                     if ($type == "Default") {
                         $ag_amt = Detail::where('agent_id', '=', $defid)
                         ->where('luckydraw_id',$luckydrawid)
                         ->where('kista_id',$kistaid)->get();
                         if($paymentid==null){
                             $wallet_amt= $ag_amt->where('payment_type',1)->sum('amount');
                             $bank_amt= $ag_amt->where('payment_type',2)->sum('amount');
                             $cash_amt= $ag_amt->where('payment_type',3)->sum('amount');
                 
                             $amt=[$wallet_amt,$bank_amt,$cash_amt];
                             $gtotal=$amt[0]+$amt[1]+$amt[2];

                             return response()->json([
                                 'respo' => $amt,
                                 'gtotal' => $gtotal,
                                 'status' => true,
                                 'agsts' =>false,
                                 'ptype' => null,
                                 'atype' => $type,
                                 'luckydraw_name' => $luckydraw_name,
                                 'kista_name' => $kista_name,
                             ]);
                         }
                         else{
                             $amt= $ag_amt->where('payment_type','=',$paymentid)->sum('amount');
                             return response()->json([
                                 'respo' => $amt,
                                 'status' => false,
                                 'atype' => $type,
                                 'agsts' =>false,
                                 'ptype' => $paymentid,
                                 'luckydraw_name' => $luckydraw_name,
                                 'kista_name' => $kista_name,
                             ]);
                         }
                     }
 }

    public function getVoucherReport(Request $request)
    {
        // dd($request->all());
        $clientid = $request->clientid;
        $agentid = $request->agentid;
        $kistaid = $request->kistaid;
        $luckydrawid = $request->luckydrawid;

        $defid = Agent::where('created_by',Auth::user()->id)
        ->where('name', 'default')->first()->id;
        $lname=LuckyDraw::where('id', $luckydrawid)->value('name');
        $kista_name = Kista::where('created_by',Auth::user()->id)
        ->where('id',$kistaid)->value('name');

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
