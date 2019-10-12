<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    /**
     * 定义gravatar方法，用来生成用户头像
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
    public static function boot()
    {
        parent::boot(); //boot 方法会在用户模型类完成初始化之后进行加载，因此我们对事件的监听需要放在该方法中。

        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    //指明一个用户可以拥有多条微博
    public function statuses(){
        return $this -> hasMany(Status::class);
    }
    //定义一个方法 取出该用户的所有微博
    public function feed()
    {
//        $user_ids = Auth::user()->followings()->pluck('id')->toArray();
        //模型关联 i 调用实例  而不是调用其方法
        $user_ids = Auth::user()->followings->pluck('id')->toArray();

        array_push($user_ids, Auth::user()->id);
        return Status::whereIn('user_id', $user_ids)
            ->with('user')
            ->orderBy('created_at', 'desc');
    }
    //获取粉丝列表 一个用户含有多个粉丝  当前为 followers_id(1) 的所有 粉丝
    public function followers()
    {
//        dd($this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id'));
        return $this->belongsToMany(User::Class, 'followers', 'user_id', 'follower_id');
    }
    //获取用户关注人
    public function followings()
    {
//        dd($this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id'));
        return $this->belongsToMany(User::Class, 'followers', 'follower_id', 'user_id');
    }
    //关注
    public function follow($user_ids){
//        dd($user_ids);
        if (!is_array($user_ids)){
//            dd($user_ids);
            $user_ids = compact('user_ids');
//            dd($user_ids);?
        }
        $this -> followings() -> sync($user_ids,false);
    }
    //取消关注
    public function unfollow($user_ids){
        if (!is_array($user_ids)) {
            $user_ids = compact('user_ids');
        }
        $this->followings()->detach($user_ids);
    }
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}