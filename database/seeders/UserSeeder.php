<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use UploadService;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $user = User::where('id', '=', 1)->first();
        $user->nickname = '用户-超管';
        $user->mobile = "18090900235";
        $user->email = "18090900235@189.cn";
        $user->password = Hash::make('admin888');
        $user->save();

        $user = User::where('id', '=', 2)->first();
        $user->nickname = '用户-编辑员';
        $user->mobile = "18180191182";
        $user->email = "18180191182@189.cn";
        $user->password = Hash::make('admin888');
        $user->save();
    }
}
