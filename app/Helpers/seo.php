<?php

if (!function_exists('create_url_seo'))
{
	function create_url_seo(string $slug, $prefix)
	{
		return $slug.'-'. $prefix;
	}
}