<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\details;
use App\profile;

class UserController extends Controller
{
  public function show($id){
     $details= json_decode(details::find($id));
     $profile= json_decode(profile::find($id));
    //  echo $details;
    //  echo $profile;
     $user = array();
     foreach ($details as $key => $value) {
      //  echo $key.'---->'.$value;
       $user[$key]=$value;
     }
     foreach ($profile as $key => $value) {
       $user[$key]=$value;
     }
    //  print_r($user);
     $all_users=array($user,);
    //  print_r($all_users);
     return view('userProfile', array('details' => $all_users));
  }

  public function index(Request $request){
    $data=$request->all();
    if(!isset($data['page'])) $data['page'] =1;
    $offset=($data['page']-1)*10;

    $join=details::with('profile')->skip($offset)->take(10)->get();
    // echo $join;
    $details= json_decode($join,true);
    $url = $request->url();
    $prev=($data['page']==1)? '#':$url.'?page='.($data['page']-1);
    //echo $prev;
    $next=$url.'?page='.($data['page']+1);
    $all_users=array();
    foreach($details as $unit){
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
}
