<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
//use App\Http\Requests;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create(){
        return view('sessions.create');
    }

    public function store(Request $request){
        $this -> validate($request,[
            'email' => 'required|email|min:3',
            'password' => 'required',
        ]);

//        dd($credentials);

        if (Auth::attempt($request->only('email', 'password'))){
            session() -> flash('success','欢迎回来');
            return redirect() -> route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的用户名和密码不匹配');
            return redirect()->back();
        }

    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
