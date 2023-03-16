<?php

namespace Database\Factories;

use BR\Person;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use League\CommonMark\Normalizer\SlugNormalizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $first_name = strval(fake('pt_BR')->firstName($gender));
        $last_name = strval(fake('pt_BR')->lastName());


        $p1username = fake()->randomElement([ Str::slug($first_name), Str::slug(($last_name))]);
        $p2username = fake()->randomElement([ Str::slug($first_name), Str::slug($last_name), random_int(0, 9999), fake()->year('now'), '.', '-', '_', '.', '-', '_', '.', '-', '_', '.', '-', '_', '.', '-', '_', '.', '-', '_', '.', '-', '_', '.', '-', '_']);
        $p3username = fake()->randomElement([ Str::slug($first_name), Str::slug($last_name), random_int(0, 99), fake()->year('now')]);

        $dominio = fake()->randomElement(['icloud.com', 'outlook.com', 'gmail.com', 'hotmail.com', 'uol.com.br', 'yahoo.com.br']);
        $email = $p1username . $p2username . $p3username . '@' . $dominio;

        $name = $first_name . ' ' . $last_name;
        return [
            'name' => $name,
            'email' => $email,
            'gender' => $gender,
            'type_user' => fake()->randomElement(['Casual', 'Profissional']),
            'date_birty' => fake()->dateTimeBetween('1990-01-01','2015-01-01')
            ->format('Y-m-d'),
            'platform' => fake()->randomElement(['PC', 'CONSOLE', 'MOBILE']),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function slug($str){
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }
}
