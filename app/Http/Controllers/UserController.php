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
}