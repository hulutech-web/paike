<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' =>'老师'. $this->faker->name(),
            //课程1-32数组
            'course' => $this->faker->randomElements([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]),
            'age'=>random_int(20,50),
            'introduce'=>$this->faker->sentence(),
            'politics_status'=>$this->faker->randomElement(['党员','团员','群众']),
            'experience'=>$this->faker->sentence(),
            'degree'=>$this->faker->word(),
        ];
    }
}
