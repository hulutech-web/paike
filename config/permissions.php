<?php

return [
    [
        'title' => '系统权限',
        'rules' => [
            ['title' => '用户管理', 'name' => 'user'],
            ['title' => '企业管理', 'name' => 'company'],
            ['title' => '系统配置', 'name' => 'system'],
        ],
    ],
    [
        'title' => '模块权限',
        'rules' => [
            ['title' => '员工模块', 'name' => 'staff'],
            ['title' => '贸易管理模块', 'name' => 'trade'],
        ],
    ],
];
