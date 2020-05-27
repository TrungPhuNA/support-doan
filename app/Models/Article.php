<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [''];

    const STATUS_ACTIVE = 1;

    public function menu()
    {
        return $this->belongsTo(Menu::class,'a_menu_id');
    }

    public function admin()
	{
		return $this->belongsTo(Admin::class,'a_admin_id');
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class,'articles_tags','at_article_id','at_tag_id');
	}
}
