<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Models\SettingEmail;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
	public function index()
	{
		$email         = SettingEmail::first();
		$configuration = Configuration::first();
		$viewData      = [
			'email'         => $email,
			'configuration' => $configuration
		];
		return view('admin::setting.index', $viewData);
	}

	public function saveSetting(Request $request)
	{
		$email = SettingEmail::first();
		if (!$email) $email = new SettingEmail();

		$email->mail_driver       = $request->mail_driver;
		$email->mail_port         = $request->mail_port;
		$email->mail_host         = $request->mail_host;
		$email->mail_username     = $request->mail_username;
		$email->mail_password     = $request->mail_password;
		$email->mail_domain       = $request->mail_domain;
		$email->mail_from_address = $request->mail_from_address;
		$email->save();

		$configuration = Configuration::first();
		if (!$configuration) $configuration = new Configuration();

		$configuration->cfg_percent_rose = $request->cfg_percent_rose;
		$configuration->save();

		\Artisan::call('config:clear');
		return redirect()->back();
	}
}