<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use App\User;
use App\profile;

use Log;

class AjaxController extends Controller
{
  public function index(Request $request){
    $data=$request->all();
    Log::info($data);
    if(!isset($data['page'])) $data['page'] =1;
    $offset=($data['page']-1)*10;
    $join=User::with('profile');
    if($request->has('sort')) {

        $join=$join->join('profiles','users.id', '=', 'profiles.id')->orderBy($request->input('sort', 'user.id'));
    }
    $join=$join->skip($offset)->take(10)->get();
    $url= 'user-profiles?'.http_build_query($data);
    $data=array('url'=>$url,'data'=>$join);
    // $User= json_decode($data,true);
    return response()->json($data);
  }
}
