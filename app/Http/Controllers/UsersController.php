<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{


    /**
     * 用户注册显示页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create ()
    {
        return view('users.create');
    }

    /**
     * 个人信息显示页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    /**
     * 创建用户保存数据页面
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // route() 方法会自动获取 Model 的主键，也就是数据表 users 的主键 id
        return redirect()->route('users.show', [$user]);

    }




}
