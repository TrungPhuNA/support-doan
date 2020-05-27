<?php


namespace Core\Test\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\Images\ThumbnailService;
use Intervention\Image\Facades\Image;

class CreateThumbnailImage extends Controller
{
	public function index()
	{
		$img = Image::make(public_path('image.png'));
		$img->fit(400, 440);
		$img->save(public_path('new_image.png'),0.8);
	}
}