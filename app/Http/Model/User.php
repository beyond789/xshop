<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //要关联的表
    protected $table = 'data_admin';
    //关联表的主键
    protected $id = 'admin_id';

    //create_at 无此字段
    public $timestamps = false;

    //黑名单为空
    protected $guarded =[];

}
