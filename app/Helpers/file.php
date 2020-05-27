<?php


use Illuminate\Support\Facades\Log;

if (!function_exists('check_pdf'))
{
	function check_pdf($extends)
	{
		if (strpos($extends,'doc') !== false || strpos($extends,'docx') !== false || strpos($extends,'ppt') !== false
			|| strpos($extends,'pptx') !== false)
			return false;

		return true;
	}
}

if (!function_exists('saveImageByUrl'))
{
	function saveImageByUrl($url, $path)
	{
		try{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$file_content = curl_exec($ch);
			curl_close($ch);

			$downloaded_file = fopen($path, 'w');
			fwrite($downloaded_file, $file_content);
			fclose($downloaded_file);
		}catch (\Exception $exception){}
	}
}


if (!function_exists('rename_pdf'))
{
	function rename_pdf($file)
	{
		if (!$file) return false;
		$name = explode('.',$file);
		if (isset($name[0]))
		{
			$filename = $name[0].'.pdf';
		}

		return $filename ?? false;
	}
}

if (!function_exists('get_total_page_word'))
{
	function get_total_page_word($path)
	{
		$total_page = 0;
		try{
			$zip = new \PhpOffice\PhpWord\Shared\ZipArchive();
			$zip->open($path);
			preg_match("/\<Pages>(.*)\<\/Pages\>/", $zip->getFromName("docProps/app.xml"), $var);
			$total_page =  $var[0] ?? 0;
		}catch (\Exception $exception)
		{
			Log::error("[get_total_page_word]. File: ". $path ." [Messages] ". $exception->getMessage());
		}

		return $total_page;
	}
}

if (!function_exists('pare_url_file')) {
	function pare_url_file($image, $folder = 'uploads')
	{
		if (!$image) {
			return '/images/no-image.jpg';
		}
		$explode = explode('__', $image);

		if (isset($explode[0])) {
			$time = str_replace('_', '/', $explode[0]);
			return '/' . $folder . '/' . date('Y/m/d', strtotime($time)) . '/' . $image;
		}
	}
}

if (!function_exists('pare_url_preview')) {
	function pare_url_preview($name, $folder = 'previews')
	{
		return '/'.$folder.'/'.$name;
	}
}