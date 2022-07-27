<?php

namespace App\Http\Controllers\Manager\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Detail;
use App\Purchase;
use App\IncomeExpenditure;
use App\Record;
use App\Client;
use App\Agent;
use App\AssetsLiabilities;
use App\Voucher;
use Illuminate\Support\Facades\Auth;
use Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadDashboard()
    {
        $current_date = date("Y-m-d");
        // $tpnp_count = Detail::where('date',$current_date)
        $tpnp_count = Detail::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        $lotteryprize_count = Detail::where('lottery_prize', '!=', null)
            ->where('created_by', Auth::user()->id)
            ->count();
        $purchase_count = Purchase::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        // $incomeexpenditure_count = IncomeExpenditure::where('date',$current_date)
        $incomeexpenditure_count = IncomeExpenditure::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        // $assetsliabilities_count = AssetsLiabilities::where('date',$current_date)
        $assetsliabilities_count = AssetsLiabilities::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        $expenditure_count = IncomeExpenditure::where('type', 'Expenditure')
            ->where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        $record_count = Record::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        // $member_count = Client::where('date',$current_date)
        $member_count = Client::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        $agent_count = Agent::where('is_active', '1')
            ->where('created_by', Auth::user()->id)
            ->count();
        $voucher_count = Voucher::count();
        $response = [
            'tpnp_count' => $tpnp_count,
            'lotteryprize_count' => $lotteryprize_count,
            'purchase_count' => $purchase_count,
            'incomeexpenditure_count' => $incomeexpenditure_count,
            'assetsliabilities_count' => $assetsliabilities_count,
            'expenditure_count' => $expenditure_count,
            'record_count' => $record_count,
            'member_count' => $member_count,
            'agent_count' => $agent_count,
            'voucher_count' => $voucher_count
        ];
        return response()->json($response);
    }
    public function index()
    {
        //
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
