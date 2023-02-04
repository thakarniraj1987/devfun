<?php

namespace App\Http\Controllers;
use App\Agent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use App\CreditReference;
use Request as resAll;

class AgentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
        $getuser = Auth::user();           
        $data['password'] = Hash::make($request['password']);
        $data['parentid'] = $getuser->id;
        $data['first_login'] = 0;
        $data['ip_address'] = resAll::ip();
        $lid=User::create($data);
		
		$last_id=$lid->id;
	
		$cref=CreditReference::create([
            'player_id' => $last_id,
            'credit' => 0,
            'remain_bal' => 0,
            'available_balance_for_D_W' => 0,
        ]);
	
        return redirect()->route('home')->with('message','Agent created successfully!'); 
    }
    public function getusername(Request $request)
    {
        $uvalue = $request->uvalue; 
        $user = User::where('user_name',$uvalue)->get();
        return response()->json(array('result'=> $user), 200);
    }
	public function storeuser(Request $request)
    {
		$getuser = Auth::user(); 
		$data = $request->all();
        $getuser = Auth::user();           
        $data['password'] = Hash::make($request['password']);
        $data['parentid'] = $getuser->id;
        $data['first_login'] = 0;
        $last_id = User::create($data)->id;
        $cref=CreditReference::create([
            'player_id' => $last_id,
            'credit' => 0,
            'remain_bal' => 0,
            'available_balance_for_D_W' => 0,
        ]);
        return redirect()->route('privileges')
        ->with('message','Agent created successfully.'); 
    }
}
