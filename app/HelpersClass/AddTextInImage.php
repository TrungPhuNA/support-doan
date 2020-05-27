<?php


namespace App\HelpersClass;


class AddTextInImage
{
	public static function addTextInImageByPackage($path, $text = 'Tailieu247.Net')
	{
		$img = \Image::make($path);
		$img->text($text, 1240, 1753, function($font) {
			$font->file(public_path('fonts/roboto-v20-latin_vietnamese-700.ttf'));
			$font->size(150);
			$font->color('#dedede');
			$font->align('center');
			$font->valign('bottom');
			$font->angle(45);
		});
		$img->save($path);
	}
}