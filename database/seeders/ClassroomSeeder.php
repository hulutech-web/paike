<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classroom;
class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'B-104',
                'seat' => '50',
                'description' => '勤学楼B-104',
                'location' => '勤学楼B-104',
            ],
            [
                'name' => 'B-103',
                'seat' => '88',
                'description' => '智远楼B-103',
                'location' => '智远楼B-103',
            ],
            [
                'name' => 'A-105',
                'seat' => '88',
                'description' => '汇知楼A-105',
                'location' => '汇知楼A-105',

            ],
            [
                'name' => 'C-106',
                'seat' => '88',
                'description' => '静思楼C-106',
                'location' => '静思楼C-106',
            ],
            [
                'name' => 'D-106',
                'seat' => '99',
                'description' => '广知楼D-106',
                'location' => '广知楼D-106',
            ],
            [
                'name' => 'F-112',
                'seat' => '67',
                'description' => '厚德楼F-112',
                'location' => '厚德楼F-112',
            ],
            [
                'name' => 'A-112',
                'seat' => '78',
                'description' => '崇文楼A-112',
                'location' => '崇文楼A-112',
            ],
            [
                'name' => 'C-111',
                'seat' => '77',
                'description' => '育才楼C-111',
                'location' => '育才楼C-111',
            ],
            [
                'name' => 'A-118',
                'seat' => '56',
                'description' => '展鹏楼A-118',
                'location' => '展鹏楼A-118',
            ],
            [
                'name' => 'A-120',
                'seat' => '56',
                'description' => '寄望楼A-120',
                'location' => '寄望楼A-120',
            ],
            [
                'name' => 'A-121',
                'seat' => '56',
                'description' => '经管楼A-121',
                'location' => '经管楼A-121',
            ],
            [
                'name' => 'A-122',
                'seat' => '56',
                'description' => '经管楼A-122',
                'location' => '经管楼A-122',
            ],
            [
                'name' => 'A-123',
                'seat' => '56',
                'description' => '经管楼A-123',
                'location' => '经管楼A-123',
            ],
            [
                'name' => 'A-124',
                'seat' => '56',
                'description' => '经管楼A-124',
                'location' => '经管楼A-124',
            ],
            [
                'name' => 'A-125',
                'seat' => '56',
                'description' => '经管楼A-125',
                'location' => '经管楼A-125',
            ],
            [
                'name' => 'A-126',
                'seat' => '56',
                'description' => '经管楼A-126',
                'location' => '经管楼A-126',
            ]
        ];

        collect($data)->map(function ($item) {
           $classroom= Classroom::create($item);
           $classroom->save();
        });
    }
}
