<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\User;
use App\profile;

use Log;
class UserController extends Controller
{
  public function show($id){
     $User= json_decode(User::with('profile')->find($id),true);
     $all_users=array($User,);
     return view('userProfile', array('details' => $all_users,'next'=>'#','prev'=>'#'));
  }

  public function index(Request $request){
    $data=$request->all();
    if(!isset($data['page'])) $data['page'] =1;
    $offset=($data['page']-1)*10;
    $join=User::with('profile')->skip($offset)->take(10)->get();
    $User= json_decode($join,true);
    $url = $request->url();
    $prev=($data['page']==1)? '#':$url.'?page='.($data['page']-1);
    $count=User::count();
    $totalPages=ceil($count/10);
    $next=($data['page']>=$totalPages)? '#':$url.'?page='.($data['page']+1);
    $all_users=array();

     return view('userProfile', array('details' => $User,'next'=>$next,'prev'=>$prev));
  }

  public function update(Request $request,$id){
    Log::info("Function executed");
    $data=$request->all();
    $update=profile::find($id);
    if($data['record']=='age') $update->age=$data['value'];
    if($data['record']=='dob') $update->DOB=$data['value'];
    $update->save();
    return response()->json($update);
  }
}
