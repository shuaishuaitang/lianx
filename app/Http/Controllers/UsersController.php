<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this -> middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    //index
    public function index(){
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }
    //创建用户生成页面
    public function create(){
        return view('users.create');
    }


    public function show(User $user){
        return view('users.show',compact('user'));
    }
    //判断数据
    public function store(Request $request){
        $this -> validate($request ,[
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6',
        ]);
        $user = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => bcrypt($request -> password),
        ]);
        Auth::login($user);//注册后自动登陆
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');  // 设置执行成功后提醒
        return redirect()->route('users.show', [$user]);
    }
    //编辑用户 创建视图
    public function edit(User $user){
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    //接收更新数据
    public function update(User $user,Request $request){
        $this -> validate($request,[
           'name' => 'required|min:6',
           'password' => 'nullable|confirmed|min:6'
        ]);
        $this->authorize('update', $user);

        //更改信息
        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session() -> flash('success', '个人资料更新成功！');
        //重定向
        return redirect() -> route('user.show',$user -> id);
    }
    //删除用户数据
    public function destroy(User $user){
        $user -> delete();
        session() -> flash('success', '成功删除用户！');
        return back();
    }
}
