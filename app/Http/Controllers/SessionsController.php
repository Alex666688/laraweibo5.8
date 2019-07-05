<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{


    /**
     * 登录显示页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create ()
    {
        return view('sessions.create');
    }

    /**
     * 用户登录数据处理页面
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store (Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            // 登录成功
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            // 登录失败
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            // 使用 withInput() 后模板里 old('email') 将能获取到上一次用户提交的内容，
            // 这样用户就无需再次输入邮箱等内容
            return redirect()->back()->withInput();
        }

    }

    /**
     * 用户登出
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy ()
    {
        // 用户退出登录
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }


}
