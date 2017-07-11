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
     return view('userProfile', array('id' => $id));
  }

  public function index(Request $request){
    // $data=$request->all();

    // 
    $join=User::with('profile');
    $join=$join->take(10)->get();
    $User= json_decode($join,true);
    return view('userProfile', array('details' => $User));
  }

  public function update(Request $request,$id){
    Log::info("Function executed");
    $data=$request->all();
    $update=profile::find($id);
    //if($data['record']=='age') $update->age=$data['value'];
    if($data['record']=='dob') $update->DOB=$data['value'];
    $update->save();
    // print_r($update);
    // echo response()->json($update);
    return response()->json($update);
  }


}
