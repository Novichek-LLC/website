<?php
namespace Database\Factories;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;
class LeadFactory extends Factory
{
    protected $model = Lead::class;
    public function definition(): array
    {
        return ['service' => $this->faker->randomElement(['1С','Маркировка','Сайт','Чат-бот']), 'name' => $this->faker->name(), 'company' => $this->faker->company(), 'email' => $this->faker->safeEmail(), 'phone' => $this->faker->phoneNumber(), 'message' => $this->faker->sentence(12), 'source' => 'seed', 'status' => 'new', 'priority' => $this->faker->randomElement(['low','medium','high'])];
    }
}
