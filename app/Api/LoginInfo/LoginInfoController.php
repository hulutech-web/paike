<?php

namespace App\Api\LoginInfo;

use App\Http\Controllers\Controller;
use DB;

class LoginInfoController extends Controller
{
    public function __invoke()
    {
        $logininfos = DB::table('personal_access_tokens')->get();
        return $logininfos;
    }
}
