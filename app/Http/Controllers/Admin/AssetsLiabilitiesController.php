<?php

namespace App\Http\Controllers\Admin;

use App\AssetsLiabilities;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AssetsLiabilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = AssetsLiabilities::orderBy('id','DESC')
        ->where('created_by', Auth::user()->id);
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
        'assetsliabilities' => $posts
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

        // dd($request->all());
        $this->validate($request, [
            'type' => 'required',
            'topic' => 'required',
            'amount' => 'required',
        ]);

        $assliab = new AssetsLiabilities();

             $assliab ->type = $request->type;
             $assliab ->topic = $request->topic;
             $assliab ->description = $request->description;
             $assliab ->amount = $request->amount;
             $assliab ->assets_type =$request->assets_type;
             $assliab ->date= $request->date;
             $assliab ->date_np= $this->helper->date_np_con_parm($request->date);
             $assliab ->time= date("H:i:s");
             $assliab ->created_by = Auth::user()->id;

             $assliab->save();
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
        $assetsliabilities = AssetsLiabilities::findOrFail($id);
        return response()->json([
            'assetsliabilities'=>$assetsliabilities
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
            'amount' => 'required',

        ]);
        $datas = AssetsLiabilities::findOrFail($id);
        $datas->update([
            'type' => $request['type'],
            'topic' => $request['topic'],
            'description' => $request['description'],
            'amount' => $request['amount'],
            'date' => $request['date'],
            'date_np' => $this->helper->date_np_con_parm($request['date']),
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
        $assetsliabilities = AssetsLiabilities::findOrFail($id);
        $assetsliabilities->delete();
        return ['message'=>'ok'];
    }
    public function status($id, $avi){
        $user = AssetsLiabilities::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
      }
}
