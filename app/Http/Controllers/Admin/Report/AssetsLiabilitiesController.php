<?php

namespace App\Http\Controllers\Admin\Report;

use App\AssetsLiabilities;
use App\Assets;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class AssetsLiabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data_assets = Assets::where('category','Assets')
                            ->with(['getAssetsLiabititiesTypeMany' => function ($query) use ($request) {
                                $query->where('type', 'Assets')
                                        ->whereBetween('date',[$request->date1,$request->date2])
                                        ->orderBy('assets_type');
                            }])
                            ->get();

        $data_liabilities = Assets::where('category','Liabilities')
                            ->with(['getAssetsLiabititiesTypeMany' => function ($query) use ($request)  {
                                $query->where('type', 'Liabilities')
                                        ->whereBetween('date',[$request->date1,$request->date2])
                                         ->orderBy('assets_type');
                            }])
                            ->get();

        $response = [
          'assets_data' => $data_assets,
          'liabilities_data' => $data_liabilities,
          'to_date' => $request->date1,
          'from_date' =>$request->date2,
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
