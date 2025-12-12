<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\ArticleImage;

class ClearArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:clear {--force : Do not ask for confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all articles, their images and related comments (destructive)';

    public function handle()
    {
        $count = Article::count();
        if ($count === 0) {
            $this->info('No articles found.');
            return 0;
        }

        $this->warn("About to delete {$count} articles and their images/comments.");
        if (! $this->option('force') && ! $this->confirm('Are you sure you want to continue? This cannot be undone.')) {
            $this->info('Aborted. No changes made.');
            return 1;
        }

        // Delete article images from storage and DB records
        $this->info('Deleting article images and thumbnails...');
        ArticleImage::chunk(100, function($images) {
            foreach ($images as $img) {
                if (!empty($img->path) && (str_starts_with($img->path, 'articles') || str_starts_with($img->path, 'storage/articles'))) {
                    // Stored path may be 'articles/...' or 'storage/articles/...'
                    $path = preg_replace('#^storage/#', '', $img->path);
                    Storage::disk('public')->delete($path);
                }
                $img->delete();
            }
        });

        // Delete article thumbnails
        Article::chunk(100, function($articles) {
            foreach ($articles as $a) {
                if (!empty($a->thumbnail) && (str_starts_with($a->thumbnail, 'articles') || str_starts_with($a->thumbnail, 'storage/articles'))) {
                    $path = preg_replace('#^storage/#', '', $a->thumbnail);
                    Storage::disk('public')->delete($path);
                }
            }
        });

        // Delete articles and cascade comments if FK cascade set; otherwise delete comments explicitly
        DB::transaction(function () {
            // If comments relation exists and no FK cascade, delete comments first
            DB::table('comments')->delete();
            DB::table('articles')->delete();
        });

        $this->info('All article records, images and comments have been deleted.');
        return 0;
    }
}
