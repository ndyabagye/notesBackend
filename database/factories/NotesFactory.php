<?php

namespace Database\Factories;

use App\Models\Notes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notes::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(255),
            'description' => $this->faker->text,
            'color' => $this->faker->text(9),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
