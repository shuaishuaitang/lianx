<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    //
    public function __construct(){
        $this -> middleware('auth');
    }
    //接收需要发送的数据
    public function store(Request $request){
        //限制规则 content
        $this -> validate($request,[
           'content' => 'required|max:40'
        ]);
        //写入数据
        Auth::user() -> statuses() -> create([
            'content' => $request['content']
        ]);
        return redirect() -> back();
    }
    //删除
    public function destroy(Status $status){
        //findorfail返会的是 “没有这条数据”。
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
