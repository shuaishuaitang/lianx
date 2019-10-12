<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users -> first();
        $user_id = $user -> id;

        //获取去除掉id为1的所有用户数组
        $followers = $users -> slice('1');
        $follower = $followers -> pluck('id') -> toArray();

        //关注除了 1 用户以外的所有用户
        $user -> follow($follower);

        //除了 1 以外用户都关注 1
       foreach ($followers as $key){
            $key -> follow($user_id);
        }

    }
}