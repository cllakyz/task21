<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $statusArr = [Task::TODO, Task::DOING, Task::DONE];

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->title,
            'description' => $this->faker->text,
            'status' => $statusArr[array_rand($statusArr, 1)]
        ];
    }
}
