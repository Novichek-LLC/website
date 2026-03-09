<?php
namespace Database\Factories;
use App\Models\CaseItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class CaseItemFactory extends Factory
{
    protected $model = CaseItem::class;
    public function definition(): array
    {
        $title = $this->faker->sentence(3);
        return ['title' => $title, 'slug' => Str::slug($title).'-'.Str::random(4), 'service' => $this->faker->randomElement(['1С','Маркировка','Сайты','Автоматизация']), 'client_name' => $this->faker->company(), 'summary' => $this->faker->sentence(16), 'content' => implode("\n\n", $this->faker->paragraphs(6)), 'result_metrics' => ['leads' => rand(10,90), 'conversion' => rand(2,15).'%'], 'is_published' => true, 'published_at' => now(), 'seo_title' => $title, 'seo_description' => $this->faker->sentence(20), 'seo_keywords' => 'кейс,автоматизация,внедрение'];
    }
}
