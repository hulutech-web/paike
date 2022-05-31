<?php

namespace App\Api\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function __invoke()
    {
        if (Auth::id() == 1) {
            return config('menus');
        } else {
            return [
                [
                    'id' => '1',
                    'pid' => 0,
                    'path' => '/admin/index',
                    'icon' => '#dashboard',
                    'title' => '首页',
                    'name' => 'admin.index',
                    'rank' => 1000,
                ]
            ];
        }
    }
}
