<?php
namespace Database\Factories;
use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;
    public function definition(): array
    {
        $title = $this->faker->sentence(4);
        return ['title' => $title, 'slug' => Str::slug($title).'-'.Str::random(4), 'excerpt' => $this->faker->sentence(12), 'content' => implode("\n\n", $this->faker->paragraphs(5)), 'is_published' => true, 'published_at' => now(), 'seo_title' => $title, 'seo_description' => $this->faker->sentence(20), 'seo_keywords' => '1с,маркировка,сайты'];
    }
}
