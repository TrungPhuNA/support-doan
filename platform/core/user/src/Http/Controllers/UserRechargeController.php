<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequestRacharge;
use App\Models\Notification;
use App\Models\SystemPay\PayIn;
use App\Services\Notifications\NotificationService;
use Carbon\Carbon;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class UserRechargeController extends Controller
{
	public function getRacherge(Request $request)
	{
		$optionsMeta = [
			'meta_title'       => 'Yêu cầu nạp tiền',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);
		$viewData    = [
			'metaSeo' => $metaSeo
		];
		return view('user::pages.recharge', $viewData);
	}

	public function postRacherge(Request $request)
	{
		if ($request->ajax())
		{
			$data['pi_status']      = PayIn::STATUS_WAIT;
			$data['pi_user_id']     = get_data_user('web');
			$data['pi_month']       = date('m');
			$data['pi_provider']    = 4;
			$data['pi_money']       = str_replace([',', '.'], '', $request->price);
			$data['pi_year']        = date('Y');
//			$data['pi_meta_detail'] = $request->meta;
			$data['created_at'] = Carbon::now();

			try {
				$id = PayIn::insertGetId($data);
				$options = array(
					'cluster' => 'ap1',
					'useTLS' => true
				);

				$pusher = new Pusher(
					env('PUSHER_APP_KEY'),
					env('PUSHER_APP_SECRET'),
					env('PUSHER_APP_ID'),
					$options
				);

				try{
					$html = "Thành viên  <b>".get_data_user('web','name')."</b> có mã 
					<b>".get_data_user('web')."</b> vừa yêu cầu nạp <b>".$request->price."</b> đ";
					$pusher->trigger('NotificationDepositRequestEvent', 'notify-deposit-request', $html);
					NotificationService::saveNotify($html, Notification::TYPE_DEPOSIT);
				}catch (\Exception $exception){
					\Log::error("pusher and notify ". $exception->getMessage());
				}

			} catch (\Exception $exception) {
				Log::error("postRacherge ". $exception->getMessage());
			}

			return response([
				'messages' => 'Yêu cầu nạp đang được xử lý'
			],200);
		}
	}
}
