<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //指定一对多关系
    public function user(){
        return $this -> belongsTo(User::class);
    }
    protected $fillable = ['content'];

}
