<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use ConvertApi\ConvertApi;
use Illuminate\Http\Request;

class AdminApiDriverController extends Controller
{
	public function index()
	{
		$setting = \DB::table('settings_api')->first();
		$data = [];
		$time = 0;
		if ($setting) {
			$data = json_decode($setting->data, true);
			$apiSecret = $data['api']['convert_file_api_secret'] ?? null;
			if ($apiSecret)
			{
				ConvertApi::setApiSecret($apiSecret);
				$time = ConvertApi::getUser()['SecondsLeft'] ?? 0;
			}
		}

		return view('admin::api_driver.setting', compact('data','time'));
	}

	public function saveSetting(Request $request)
	{
		$data = [];
		if ($request->convert_file_api_secret)
		{
			$data['api'] = [
				'convert_file_api_secret' => $request->convert_file_api_secret
			];
		}
		$setting = \DB::table('settings_api')->first();
		$data = json_encode($data);
		if ($setting)
		{
			\DB::table('settings_api')->update([
				'data' => $data
			]);
		}else{
			\DB::table('settings_api')->insert([
				'data' => $data
			]);
		}

		return redirect()->back();
	}

	public function restartFlagErrorSystem()
	{
		$setting = Setting::first();

		if ($setting && $setting->is_error_system == Setting::STATUS_ERRORS)
		{
			\DB::table('settings_api')->update([
				'is_error_system' => Setting::STATUS_SUCCESS
			]);
		}

		return redirect()->back();
	}
}