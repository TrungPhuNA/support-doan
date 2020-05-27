<?php


namespace App\HelpersClass;


class ContactHelper
{
	public function detectPhone($string, $clear = false)
	{
		if (!$string) return null;

		$selectors = [
			'regex'        => '/^(0|\+84|\84)(\d{9,10})$/',
			'replace_char' => ['.', ' ', ','],
		];
		preg_match_all($selectors['regex'], $string, $result);
		$data = isset($result[0]) ? implode('|', array_unique($result[0])) : '';
		if ($clear)
		{
			$data = trim(str_replace($selectors['replace_char'], '', $data));
		}
		return $data;
	}

	public function detectEmail($string)
	{
		if (!$string) return null;

		$selectors = [
			'regex' => '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}/mi',
		];
		preg_match_all($selectors['regex'], $string, $result);
		$data = isset($result[0]) ? implode('|', array_unique($result[0])) : '';
		return $data;
	}
}