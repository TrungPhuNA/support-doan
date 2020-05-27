<?php

namespace Core\Admin\Http\Controllers;

use App\Models\SeoBlog;
use App\Models\Tag;
use Core\Admin\Services\RenderUrlSeoBlogServices;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequestArticle;
use App\Models\Article;
use App\Models\Menu;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminArticleController extends AdminBaseController
{
	public function index()
	{
		$articles = Article::with('menu:id,mn_name')
			->orderByDesc('id')
			->paginate(10);
		$viewData = [
			'articles' => $articles
		];

		return view('admin::article.index', $viewData);
	}

	public function create()
	{
		$menus  = Menu::all();
		$tags   = Tag::all();
		$tagOld = [];

		return view('admin::article.create', compact('menus', 'tags', 'tagOld'));
	}

	public function store(AdminRequestArticle $request)
	{
		$data               = $request->except('_token', 'a_avatar', 'a_position_1', 'a_position_2', 'tags');
		$data['a_slug']     = Str::slug($request->a_name);
		$data['a_admin_id'] = get_data_user('admins');
		$data['created_at'] = Carbon::now();

		if ($request->a_position_1) {
			$data['a_position_1'] = 1;
		}

		if ($request->a_position_2) {
			$data['a_position_2'] = 1;
		}

		if ($request->a_avatar) {
			$image = upload_image('a_avatar');
			if ($image['code'] == 1)
				$data['a_avatar'] = $image['name'];
		}

		$id = Article::insertGetId($data);
		if ($id)
		{
			if ($request->tags)
				$this->syncTags($request->tags, $id);
		}

//		\OneSignal::sendNotificationToAll(
//			$request->a_name,
//			$url = route('get.render_url_seo_blog',$data['a_slug'].'-'.'a-'.$id),
//			$data = null,
//			$buttons = null,
//			$schedule = null
//		);

//		RenderUrlSeoBlogServices::renderUrlBLog($data['a_slug'].'-'.SeoBlog::SLUG_ARTICLE.'-'.$id, SeoBlog::TYPE_ARTICLE, $id);

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function edit($id)
	{
		$article = Article::find($id);
		$menus   = Menu::all();
		$tags    = Tag::all();

		$tagOld = \DB::table('articles_tags')
			->where('at_article_id', $id)
			->pluck('at_tag_id')
			->toArray();

		if (empty($tagOld)) $tagOld = [];

		return view('admin::article.update', compact('menus', 'article', 'tags', 'tagOld'));
	}

	public function update(AdminRequestArticle $request, $id)
	{
		$article            = Article::find($id);
		$data               = $request->except('_token', 'a_avatar', 'a_position_1', 'a_position_2', 'tags');
		$data['a_slug']     = Str::slug($request->a_name);
		$data['updated_at'] = Carbon::now();

		if ($request->a_position_1) {
			$data['a_position_1'] = 1;
		} else {
			$data['a_position_1'] = 0;
		}

		if ($request->a_position_2) {
			$data['a_position_2'] = 1;
		} else {
			$data['a_position_2'] = 0;
		}

		if ($request->a_avatar) {
			$image = upload_image('a_avatar');
			if ($image['code'] == 1)
				$data['a_avatar'] = $image['name'];
		}

		$article->update($data);
		if ($request->tags)
			$this->syncTags($request->tags, $id);

//		RenderUrlSeoBlogServices::renderUrlBLog($article->a_slug.'-'.SeoBlog::SLUG_ARTICLE.'-'.$id, SeoBlog::TYPE_ARTICLE, $id);

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function active($id)
	{
		$article           = Article::find($id);
		$article->a_active = !$article->a_active;
		$article->save();

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function hot($id)
	{
		$article        = Article::find($id);
		$article->a_hot = !$article->a_hot;
		$article->save();
		$this->getMessagesSuccess();

		return redirect()->back();
	}

	private function syncTags($tags, $idArticle)
	{
		if (!empty($tags)) {
			$datas = [];
			foreach ($tags as $key => $tag) {
				$datas[] = [
					'at_tag_id'     => $tag,
					'at_article_id' => $idArticle
				];
			}

			\DB::table('articles_tags')->where('at_article_id', $idArticle)->delete();
			\DB::table('articles_tags')->insert($datas);
		}
	}

	public function delete($id)
	{
		$article = Article::find($id);
		if ($article){
			$slug = $article->a_slug.'-'.$article->id.'-'. SeoBlog::SLUG_ARTICLE;
			SeoBlog::where([
				'sb_md5'  => md5($slug),
				'sb_type' => SeoBlog::TYPE_ARTICLE
			])->delete();
			$article->delete();
		}
		$this->getMessagesSuccess();

		return redirect()->back();
	}

}
