<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create or update a normal test user (password: secret)
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('secret'), 'is_admin' => false]
        );

        // Create or update an admin user (email: admin@example.com, password: secret)
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('secret'), 'is_admin' => true, 'role' => 'admin']
        );

        // create or update a sample editor user
        User::updateOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor', 'password' => bcrypt('secret'), 'role' => 'editor']
        );

        // create home page if not exists
        \App\Models\Page::updateOrCreate(['slug'=>'home'], ['title'=>'Bem-vindo ao Portal','content'=>'<p>Edite esta página pelo painel admin.</p>']);

        // create contact page if not exists (editable via admin)
        \App\Models\Page::updateOrCreate(
            ['slug' => 'contact'],
            ['title' => 'Contato', 'content' => '<p>Use o painel administrativo para editar as informações desta página.</p>']
        );

        // create about page if not exists (editable via admin)
        \App\Models\Page::updateOrCreate(
            ['slug' => 'about'],
            ['title' => 'Sobre', 'content' => '<p>Use o painel administrativo para editar as informações desta página (Sobre).</p>']
        );

        // Create 5 generic fake articles for development
        Article::factory()->count(5)->create();

        // Add 5 articles for each of the seed users (admin and test)
        $users = User::whereIn('email', ['test@example.com', 'admin@example.com'])->get();
        foreach ($users as $user) {
            Article::factory()->count(5)->create(['user_id' => $user->id]);
        }

        // Attach 0-3 fake images (external URLs) to each article when seeding
        $faker = \Faker\Factory::create();
        foreach (Article::all() as $article) {
            $count = rand(0,3);
            for ($i=0;$i<$count;$i++) {
                $url = $faker->imageUrl(800,600);
                \App\Models\ArticleImage::create(['article_id'=>$article->id,'path'=>$url,'position'=>$i]);
            }
            // if article has no thumbnail but has images, set thumbnail to first image
            if (! $article->thumbnail && $article->images()->exists()) {
                $first = $article->images()->first();
                $article->thumbnail = $first->path;
                $article->save();
            }
        }
    }
}
