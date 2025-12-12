<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_articles(): void
    {
        Article::factory()->create(['title' => 'Notícia de teste']);

        $response = $this->get('/articles');

        $response->assertStatus(200);
        $response->assertSee('Portal de Notícias');
        $response->assertSee('Notícia de teste');
    }

    public function test_show_displays_article(): void
    {
        $article = Article::factory()->create(['title' => 'Mostrada']);

        $response = $this->get('/articles/'.$article->id);

        $response->assertStatus(200);
        $response->assertSee('Mostrada');
    }
}
