<?php

namespace App\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{


    public function scanQr()
    {
        $code = mt_rand(1000, 9999);

        cache(['code_'.$code => $code], 60);

        return base64_encode(QrCode::format('png')->generate($code));
    }


    /**
     * @param Request $request
     */
    public function scanLogin(Request $request)
    {
        $request->validate([
            'mobile' => ['required', Rule::exists('users', 'mobile')],
        ]);
        $isChecked = cache('code_'.$request->code) == $request->code;

        if ($isChecked) {
            $user = User::where('mobile', '=', $request->mobile)->first();
            Auth::login($user);
            return ['message' => '登录成功', 'token' => $this->token(Auth::user()), 'data' => Auth::user()];
        } else {
            return $this->error('登录失败');
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => ['required', Rule::exists('users', 'mobile')],
            'password' => ['required', Password::min(8)],
        ], [
            'mobile' => '帐号不能为空',
            'mobile.exists' => '帐号不存在',
            'password.required' => '密码不能为空',
        ]);
        $isLogin = Auth::attempt([
            'mobile' => $request->mobile,
            'password' => $request->password
        ]);
        if ($isLogin) {
            return ['message' => '登录成功', 'token' => $this->token(Auth::user()), 'data' => Auth::user()];
        }
        return response(['message' => '帐号或密码错误'], 405);
    }


    protected function token(User $user)
    {
        return $user->createToken('auth:desktop')->plainTextToken;
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->message('帐号退出成功');
    }

    /**
     * 注册帐号
     *
     * @param Request $request
     * @return void
     */
    public function register(Request $request, User $user)
    {
        $request->validate([
            'account' => ['required', Rule::unique('users', 'mobile')],
            'password' => ['required', 'confirmed', 'between:5,20'],
        ], [
            'account.required' => '帐号不能为空',
            'account.unique' => '帐号已经被注册',
            'password.required' => '密码不能为空', 'code.required' => '验证码不能为空'
        ]);

        $user->password = Hash::make($request->password);
        $user->mobile = $request->mobile;
        $user->save();
        return $this->message('注册成功');
    }

    /**
     * 找回密码
     *
     * @param Request $request
     * @return void
     */
    public function forget(Request $request, User $user)
    {
        $request->validate([
            'account' => ['required', Rule::exists('users', $request->user)],
            'password' => ['required', 'confirmed', 'between:5,20'],
        ], [
            'account.required' => '帐号不能为空',
            'account.exists' => '帐号不存在',
            'password.required' => '密码不能为空',
        ]);

        $user = User::where('id', '=', $request->id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return ['message' => '密码重置成功', 'token' => $this->token($user)];
    }
}
