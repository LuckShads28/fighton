<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Turnamen Valo ' . fake()->unique()->randomDigit();
        $slug = Str::slug($name, '-');
        return [
            'id_organizer' => random_int(1, 2),
            'name' => $name,
            'slug' => $slug,
            'about' => fake()->paragraph(),
            'rules' => fake()->paragraph(),
            'prizepool' => 1000000,
            'team_slot' => 5,
            'team_category' => '5v5',
            'start_date' => fake()->dateTimeThisYear('+3 months'),
            'start_time' => fake()->time(),
            'tournament_type' => 'auto_join',
        ];
    }
}
