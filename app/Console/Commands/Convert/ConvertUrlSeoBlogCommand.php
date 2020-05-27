<?php

namespace App\Console\Commands\Convert;

use App\Models\Article;
use App\Models\Menu;
use App\Models\SeoBlog;
use App\Models\Tag;
use Core\Admin\Services\RenderUrlSeoBlogServices;
use Illuminate\Console\Command;

class ConvertUrlSeoBlogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo_blog:url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create url seo Blog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $menus = Menu::all();
        foreach ($menus as $menu) {
        	$this->info("-- ". $menu->mn_name);
			RenderUrlSeoBlogServices::renderUrlBLog($menu->mn_slug.'-'.SeoBlog::SLUG_MENU.'-'.$menu->id, SeoBlog::TYPE_MENU, $menu->id);
		}

        $tags = Tag::all();
		foreach ($tags as $tag) {
			$this->info("-- ". $tag->t_name);
			RenderUrlSeoBlogServices::renderUrlBLog($tag->t_slug.'-'.SeoBlog::SLUG_TAG.'-'.$tag->id, SeoBlog::TYPE_TAG, $tag->id);
		}

		$articles = Article::all();
		foreach ($articles as $article) {
			$this->info("-- ". $article->a_name);
			RenderUrlSeoBlogServices::renderUrlBLog($article->a_slug.'-'.SeoBlog::SLUG_ARTICLE.'-'.$article->id, SeoBlog::TYPE_ARTICLE, $article->id);
		}
    }
}
