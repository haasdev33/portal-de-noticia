<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $categories = ['Geral', 'Tecnologia', 'Negócios', 'Saúde', 'Educação', 'Esportes'];
        
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraphs(asText: true),
            'published_at' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'thumbnail' => $this->faker->optional()->imageUrl(800, 600),
            'category' => $this->faker->randomElement($categories),
            'user_id' => null,
        ];
    }
}
