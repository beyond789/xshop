<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /*
      * 方法的功能：返回后台首页
      * @author:  赵小庭
      * @date:  2017.08.05
      * @return 后台首页
      */
    public function index()
    {

        return view('admin.index');
    }

}
