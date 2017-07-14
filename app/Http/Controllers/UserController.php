<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\User;
use App\profile;
use Carbon\Carbon;
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
    $date=new Carbon($data['value']);
    if($date->lte(Carbon::now())){
      if($data['record']=='dob') $update->DOB=$data['value'];
      $update->save();
      $msg="Date of Birth of user ".$update->id." changed to ".$update->DOB.". New age is ".$update->age;
      $status='success';
    }else{
      $msg="Date of Birth cannot be greater than today";
      $status='error';
    }
    $res=array('update'=>$update,'msg'=>$msg,'status'=>$status);
    return response()->json($res);
  }


}
