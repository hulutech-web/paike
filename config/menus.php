<?php

return [
    [
        'id' => '1',
        'pid' => 0,
        'path' => '/admin/index',
        'icon' => '#dashboard',
        'title' => '首页',
        'name' => 'admin.index',
        'rank' => 1000,
    ],
    [
        'id' => '2',
        'pid' => 0,
        'path' => '/admin/user',
        'icon' => '#avatar',
        'title' => '用户管理',
        'name' => 'admin.user',
        'rank' => 2000,
        'children' => array([
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/user/index',
            'icon' => '#data-user',
            'title' => '用户列表',
            'name' => 'admin.user.index',
            'rank' => 2100,
        ])
    ],
    [
        'id' => '4',
        'pid' => 0,
        'path' => '/admin/teacher',
        'icon' => '#user-business',
        'title' => '教师管理',
        'name' => 'admin.teacher',
        'rank' => 2000,
        'children' => array([
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/teacher/index',
            'icon' => '#list',
            'title' => '教师列表',
            'name' => 'admin.teacher.index',
            'rank' => 2100,
        ])
    ],
    [
        'id' => '4',
        'pid' => 0,
        'path' => '/admin/course',
        'icon' => '#mail',
        'title' => '课程管理',
        'name' => 'admin.course',
        'rank' => 2000,
        'children' => array([
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/course/index',
            'icon' => '#analysis',
            'title' => '课程列表',
            'name' => 'admin.course.index',
            'rank' => 2100,
        ])
    ],
    [
        'id' => '3',
        'pid' => 0,
        'path' => '/admin/schedule',
        'icon' => '#building-four',
        'title' => '排课管理',
        'name' => 'admin.schedule',
        'rank' => 2000,
        'children' => array([
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/schedule/index',
            'icon' => '#treasure-chest',
            'title' => '排课列表',
            'name' => 'admin.schedule.index',
            'rank' => 2100,
        ], [
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/schedule/create',
            'icon' => '#add',
            'title' => '添加排课',
            'name' => 'admin.schedule.create',
            'rank' => 2100,
        ],
            [
                'id' => '3',
                'pid' => 2,
                'path' => '/admin/schedule/add',
                'icon' => '#add',
                'title' => '增加排课',
                'name' => 'admin.schedule.add',
                'rank' => 2100,
            ])
    ],
    [
        'id' => '3',
        'pid' => 0,
        'path' => '/admin/classroom',
        'icon' => '#building-four',
        'title' => '教室管理',
        'name' => 'admin.classroom',
        'rank' => 2000,
        'children' => array([
            'id' => '3',
            'pid' => 2,
            'path' => '/admin/classroom/index',
            'icon' => '#treasure-chest',
            'title' => '教室列表',
            'name' => 'admin.classroom.index',
            'rank' => 2100,
        ])
    ],
    [
        'id' => '7',
        'pid' => 0,
        'path' => '/system/index',
        'icon' => '#system',
        'title' => '系统配置',
        'name' => 'admin.system',
        'rank' => 4000,
        'children' => array([
            'id' => '8',
            'pid' => 7,
            'path' => '/admin/system/index',
            'icon' => '#application-menu',
            'title' => '系统配置',
            'name' => 'admin.system.edit',
            'rank' => 4100
        ], [
            'id' => '9',
            'pid' => 7,
            'path' => '/admin/system/logininfo',
            'icon' => '#face-recognition',
            'title' => '登录信息',
            'name' => 'admin.system.logininfo',
            'rank' => 4200
        ])
    ],
];

