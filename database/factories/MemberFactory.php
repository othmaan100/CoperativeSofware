<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'application_no' => 'FCET/CSL/'.$this->faker->unique()->numerify('#####'),
            'membership_no' => 'FCET/CSL/'.$this->faker->unique()->numerify('STAFF###'),
            'full_name' => $this->faker->name(),
            'date_of_birth' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),
            'home_address' => $this->faker->address(),
            'phone_1' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'department' => $this->faker->randomElement(['Bursary', 'Registry', 'Academics']),
            'staff_id' => $this->faker->unique()->numerify('FCET-####'),
            'employment_status' => 'permanent',
            'staff_category' => $this->faker->randomElement(['senior_staff', 'junior_staff']),
            'preferred_monthly_contribution' => 5000,
            'approved_monthly_contribution' => 5000,
            'mode_of_deduction' => 'salary_deduction',
            'member_category' => 'regular_staff',
            'declaration_accepted' => true,
            'declaration_signed_name' => $this->faker->name(),
            'status' => 'active',
            'applied_at' => now()->subMonths(8),
            'approved_at' => now()->subMonths(8),
        ];
    }
}
