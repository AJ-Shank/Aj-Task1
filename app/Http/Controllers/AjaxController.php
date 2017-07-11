<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\User;
use App\profile;

use Log;
use Carbon\Carbon;
class AjaxController extends Controller
{
  public function index(Request $request){
    $data=$request->all();
    Log::info($data);
    if(!isset($data['page'])) $data['page'] =1;
    $offset=($data['page']-1)*10;
    $join=User::with('profile')->join('profiles','users.id', '=', 'profiles.id');
    if($request->has('search')) {
        $join=$join->where('name', 'like', '%' . $request->input('search','') . '%');
    }
    if($request->has('sort')) {
        $join=$join->orderBy($request->input('sort', 'user.id'));
    }
    if($request->has('lower')) {
          $now=Carbon::now()->subYears($request->input('lower', '0'));
          $join=$join->where('DOB','<=', $now );
    }
    if($request->has('upper')) {
          $now=Carbon::now()->subYears($request->input('upper', '0'));
          $join=$join->where('DOB','>=', $now );
    }
    $table=$join->skip($offset)->take(10)->get();
    $url= 'user-profiles?'.http_build_query($data);
    $prev="#";$next="#";
    if($data['page']>1) {
      $data['page']-=1;
      $prev= 'user-profiles?'.http_build_query($data);
      $data['page']+=1;
    }
    $count=$join->count();
    $totalPages=ceil($count/10);
    if($data['page']<$totalPages){
      $data['page']+=1;
      $next= 'user-profiles?'.http_build_query($data);
      $data['page']-=1;
    }

    $data=array('url'=>$url,'data'=>$table,'prev'=>$prev,'next'=>$next);
    // $User= json_decode($data,true);
    return response()->json($data);
  }
  public function show($id){
    $join=User::with('profile')->find($id);
    $data=array('url'=>$id,'data'=>array($join));
    return response()->json($data);
  }
}
