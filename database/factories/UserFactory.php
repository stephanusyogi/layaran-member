<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class; 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => (string) Str::uuid(),
            'first_name'   => $this->faker->firstName(),
            'last_name'    => $this->faker->lastName(),
            'email_address' => $this->faker->unique()->safeEmail(),
            'password'     => Hash::make('@password123'),
            'role'         => 'member',
            'phone_number' => $this->generateIndonesianPhoneNumber(),
            'profession'   => $this->faker->jobTitle(),
            'gender'       => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'knowing_from' => $this->faker->randomElement(['Google', 'Facebook', 'Friend', 'Advertisement']),
        ];
    }

    private function generateIndonesianPhoneNumber(): string
    {
        $prefixes = ['0811', '0812', '0813', '0821', '0822', '0823', '0851', '0852', '0853', '0856', '0857', '0858', '0877', '0878', '0881', '0882', '0883', '0884'];
        $prefix = $this->faker->randomElement($prefixes); 
        $number = $this->faker->numerify('#######');
        
        return $prefix . $number;
    }

}
