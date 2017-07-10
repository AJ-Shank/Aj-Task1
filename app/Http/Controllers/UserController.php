<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;
use App\profile;

use Log;
class UserController extends Controller
{
  public function show($id){
     $User= json_decode(User::find($id));
     $profile= json_decode(profile::find($id));
     $user = array();
     foreach ($User as $key => $value) {
       $user[$key]=$value;
     }
     foreach ($profile as $key => $value) {
       $user[$key]=$value;
     }
     $all_users=array($user,);
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
    foreach($User as $unit){
      $user=array();
      $user['id']= $unit['id'];
      $user['name']= $unit['name'];
      $user['email']= $unit['email'];
      $user['age']= $unit['profile']['age'];
      $user['DOB']= $unit['profile']['DOB'];
      $all_users[]=$user;
    }
     return view('userProfile', array('details' => $all_users,'next'=>$next,'prev'=>$prev));
  }

  public function update(Request $request,$id){
    Log::info("Function executed");
    $data=$request->all();
    $update=profile::find($id);
    if($data['record']=='age') $update->age=$data['value'];
    if($data['record']=='dob') $update->DOB=$data['value'];
    $update->save();

  }
}
