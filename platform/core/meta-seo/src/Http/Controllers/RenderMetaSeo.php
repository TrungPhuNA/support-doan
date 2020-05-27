<?php

namespace Core\MetaSeo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class RenderMetaSeo extends Controller
{
	protected $options = array();
	protected $metaTitle;
	protected $metaDescription;
	protected $metaKeywords;
	protected $metaImage ;
	protected $metaRobots;
	protected $sizeImage;
	private   $widthImage        = '600';
	private   $heightImage       = '315';

	protected $metaDefault = [
		'image'     => '/images/social.png',
		'robots'    => 'NOINDEX, NOFOLLOW'
	];

	public static function MetaSeo($options = array())
	{
		$self = new self();
		$self->options = $options;

		$self->setMetaTitle();
		$self->setMetaDescription();
		$self->setMetaKeywords();
		$self->setMetaImage();
		$self->setMetaRobots();

		return $self;
	}

	public function setMetaTitle()
	{
		return $this->metaTitle = Arr::get($this->options,'meta_title','');
	}

	public function setMetaDescription()
	{
		return $this->metaDescription = Arr::get($this->options,'meta_description','');
	}

	public function setMetaKeywords()
	{
		return $this->metaKeywords = Arr::get($this->options,'meta_keywords','');
	}

	public function setMetaImage()
	{
		return $this->metaImage = \Request::root().Arr::get($this->options,'meta_image',$this->metaDefault['image']);
	}

	public function setMetaRobots()
	{
//		return $this->metaRobots = 'NOINDEX, NOFOLLOW';
		return $this->metaRobots = Arr::get($this->options,'meta_robots',$this->metaDefault['robots']);
	}

	public function renderMetaSeo()
	{
		$domain = request()->getHost();
		$that  = $this;
		$meta = '<meta charset="UTF-8">';
		// $meta .= '<meta name="google-site-verification" content="cKQMogTk9VqkdyhGzLUPdMhOvaIms4-frvRV4BnywiA" />';
		$meta .= '<title>'.$that->metaTitle.' | '.$domain.'</title>';
		$meta .= '<meta name="description" content="'.$that->metaDescription.'"/>';
		$meta .= '<meta name="keywords" itemprop="keywords" content="'.$that->metaKeywords.'"/>';
		$meta .= '<meta name="language" content="vietnamese"/>';
		$meta .= '<meta name="csrf-token" content="'.csrf_token().'">';

//		$image = 'http://tailieu247.net/images/social.png';
//		$meta .= '<meta itemprop="image" content="'.$image.'">
//                            <meta property="og:image" content="'.$image.'" />
//                            <meta property="og:image:width" content="'.$that->widthImage.'">
//	                        <meta property="og:image:height" content="'. $that->heightImage .'">';

		$meta .= '<meta itemprop="image" content="'.$that->metaImage.'">
					<meta property="og:image" content="'.$that->metaImage.'" />
					<meta property="og:image:width" content="'.$that->widthImage.'">
					<meta property="og:image:height" content="'. $that->heightImage .'">';

		$meta .= '<meta name="author" content="Đang cập nhật">';
		$meta .= '<meta http-equiv="content-language" content="vi" />';
		$meta .= '<meta name="GENERATOR" content="">';
		$meta .= '<meta name="copyright" content="Copyright © 2020 by">';
		$meta .= '<meta property="og:description" content="'.$this->metaDescription.'">';
		$meta .= '<meta property="og:locale" content="vi_VN" />';
		$meta .= '<meta property="og:title" itemprop="name" content="'.$this->metaTitle.'">';
		$meta .= '<meta name="ROBOTS" content="'.$this->metaRobots.'">';
		$meta .= '<link rel="canonical" href="'.\Request::url().'" />';
		$meta .= '<link rel="shortcut icon" href="'.\URL::to("ico.ico").'">';
		$meta .= '<meta name="theme-color">';

		return $meta;
	}
}