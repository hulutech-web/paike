<?php

namespace App\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index()
    {
        $users = User::all();
        return $users;
    }

    public function store(Request $request, User $user)
    {
        $user->fill($request->input());
        $user->password = Hash::make($request->password);
        $user->save();
        return $this->message('保存成功');
    }


    public function show(User $user)
    {
        return $user;
    }


    public function update(Request $request, User $user)
    {
        $user->update($request->input());
        return $this->message('修改成功', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->message("删除成功");
    }


    public function search(Request $request)
    {
        return User::search($request->keyword)->get();
    }
}
