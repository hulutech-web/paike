<?php

namespace App\Services\Menu;

use Auth;

/**
 * 菜单服务
 * @package App\Services
 */
class MenuService
{

    public function generateMenus()
    {

    }

//    获取菜单
    public function getMenus()
    {
        $menu_system = config('menus');

    }

//    生成菜单树形结构
    public function generateMenuTree($menu_system)
    {
        $menu_tree = [];
        foreach ($menu_system as $menu) {
            if ($menu['parent_id'] == 0) {
                $menu_tree[$menu['id']] = $menu;
            } else {
                $menu_tree[$menu['parent_id']]['children'][] = $menu;
            }
        }
        return $menu_tree;
    }

//    获取菜单树形结构
    public function getMenuTree()
    {
        $menu_system = config('menus');
        $menu_tree = $this->generateMenuTree($menu_system);
        return $menu_tree;
    }
}
