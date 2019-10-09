<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

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
        return $this->statuses()
            ->orderBy('created_at', 'desc');
    }
}
