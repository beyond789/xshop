<?php
//命名空间
namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//验证码命名空间引入
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
     * 方法的功能：返回后台用户登录页面
     * @author:  赵小庭
     * @date:  2017.08.04
     * @return 登录页面
     */
    public function login()
    {
        return view('admin.login');
    }

    // 验证码生成
    public function captcha($tmp)
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        // 可以设置图片宽高及字体
        $builder->build($width = 100, $height = 40, $font = null);
        // 获取验证码的内容
        $phrase = strtoupper($builder->getPhrase());
        // 把内容存入session
        \Session::flash('code', $phrase);
        // 生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    /*后台用户登录的身份验证
     * author  赵小庭
     * param  $request
     * date  2017.08.04
     */
    public function dologin(Request $request)
    {
//      dd($request->all());
        $input = Input::except('_token');
//        dd($input);
        //验证用户名   密码  验证码
        //创建用户模型
        $user = User::where('admin_name',$input['username'])->first();
//        dd($user);

        if(!$user){
            return back()->with('error','无此用户');
        }

//        dd($input['password']);
//         密码验证
        if(Crypt::decrypt($user->admin_pass) != trim($input['password']) ){
            return back()->with('error','密码错误');
        }

//        验证码
        if(strtoupper($input['code']) != session('code')){
            return back()->with('error','验证码错误');
        }

//        //登陆成功,保存用户登录状态,进入后台首页
        session(['user'=>$user]);
        return redirect('admin/index');


    }



}
