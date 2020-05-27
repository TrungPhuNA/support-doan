<?php

if (!function_exists('render_ga')) {
	function render_ga()
	{
		if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Speed Insights') === false && app()->environment() !== 'local') {
			return "<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-164676012-1\"></script>
                    <script>
                        window.dataLayer = window.dataLayer || [];
                
                        function gtag() {
                            dataLayer.push(arguments);
                        }
                        gtag('js', new Date());
                        gtag('config', 'UA-164676012-1');
                    </script>
                    ";
		}
	}
}

if (!function_exists('show_debug'))
{
	function show_debug()
	{
		$arrayIP  = [
			'127.0.0.1',
			'1.53.39.52'
		];

		if (in_array(get_client_ip(), $arrayIP)) return true;

		return false;
	}
}