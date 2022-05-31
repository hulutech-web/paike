<?php

namespace App\Api\SystemConfig;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function showConfig()
    {
        $systemConfig = SystemConfig::find(1);
//        return dd($systemConfig);
        return $systemConfig;
    }


    public function updateSystemConfig(Request $request)
    {
//        return $request->all();
        $systemConfig = SystemConfig::find(1);
        if ($systemConfig) {
            $systemConfig->update($request->all());
            return $this->message('修改成功');
        } else {
            SystemConfig::updateOrCreate($request->all());
            return $this->message('修改成功');
        }
    }
}
