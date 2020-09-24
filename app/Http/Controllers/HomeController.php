<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function ViewOrder()
    {
        
        $sql = DB::select("select * from custorder");
        $data = json_decode(json_encode($sql),true);
        return $data;
    }
    public function changeStatus(Request $request)
    {
        $id = $request->get('id');
        $status = $request->get('status');
        DB::table('custorder')
        ->where('id',$id)
        ->update([
          'status'       => $status,
           ]);
    }
}
