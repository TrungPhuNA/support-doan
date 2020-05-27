<?php

namespace Core\Admin\Http\Controllers\SystemPay;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequestPayIn;
use App\Models\SystemPay\PayHistory;
use App\Models\SystemPay\PayIn;
use App\User;
use Carbon\Carbon;
use Core\Admin\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;

class AdminPayInController extends AdminBaseController
{
	public function index(Request $request)
	{
		$payIns = PayIn::with('admin:id,name', 'user:id,name,phone,email');
		if ($request->status)
			$payIns->where('pi_status', $request->status);

		$payIns = $payIns
			->orderByDesc('id')
			->paginate(10);

		$status   = (new PayIn())->getStatus();
		$viewData = [
			'status' => $status,
			'payIns' => $payIns,
			'query'  => $request->query()
		];

		return view('admin::system_pay.pay_in.index', $viewData);
	}

	public function create()
	{
		$users = User::select('id', 'name', 'email', 'phone')
			->get();

		return view('admin::system_pay.pay_in.create', compact('users'));
	}

	public function store(AdminRequestPayIn $request)
	{
		$data               = $request->except('_token');
		$data['pi_status']  = PayIn::STATUS_PROCESS;
		$data['pi_month']   = date('m');
		$data['pi_year']    = date('Y');
		$data['created_at'] = Carbon::now();

		$data['pi_admin_id'] = get_data_user('admins');

		$id = PayIn::insertGetId($data);

		if ($id) {
			$user          = User::find($request->pi_user_id);
			$user->balance += $data['pi_money'];
			$user->save();

			$this->syncPayHistories($data, $id, $user->balance);
			$this->getMessagesSuccess();
		}

		return redirect()->back();
	}

	protected function syncPayHistories($data, $payInId, $balance)
	{
		PayHistory::insert([
			'ph_code'    => 'IN' . $payInId,
			'ph_user_id' => $data['pi_user_id'],
			'ph_credit'  => $data['pi_money'],
			'ph_balance' => $balance,
			'ph_status'  => 1,
			'ph_month'   => date('m'),
			'ph_year'    => date('Y'),
			'created_at' => Carbon::now()
		]);
	}

	public function edit($id)
	{
		$users = User::select('id', 'name', 'email', 'phone')
			->get();
		$payIn = PayIn::find($id);

		return view('admin::system_pay.pay_in.update', compact('users', 'payIn'));
	}


	public function update(Request $request, $id)
	{
		$payIn              = PayIn::find($id);
		$payIn->pi_user_id  = $request->pi_user_id;
		$payIn->pi_provider = $request->pi_provider;
		$payIn->save();
		$this->getMessagesSuccess();

		return redirect()->back();
	}

	public function delete($id)
	{
		$payIn = PayIn::find($id);
		if ($payIn && $payIn->pi_status >= 2) {
			$this->getMessagesErrors();
			return redirect()->back();
		}

		$payIn->delete();
		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function cancel($id)
	{
		$payIn = PayIn::find($id);
		if ($payIn && $payIn->pi_status >= 2) {
			$this->getMessagesErrors();

			return redirect()->back();
		}

		$payIn->pi_status   = PayIn::STATUS_CANCEL;
		$payIn->pi_admin_id = get_data_user('admins');
		$payIn->save();

		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function process($id)
	{
		$payIn = PayIn::find($id);
		if ($payIn && $payIn->pi_status >= 2) {
			$this->getMessagesErrors();
			return redirect()->back();
		}
		$payIn->pi_status   = PayIn::STATUS_PROCESS;
		$payIn->pi_admin_id = get_data_user('admins');
		$payIn->save();

		$user          = User::find($payIn->pi_user_id);
		$user->balance += $payIn->pi_money;
		$user->save();

		$data = [
			'pi_user_id' => $user->id,
			'pi_money'   => $payIn->pi_money
		];

		$this->syncPayHistories($data, $id, $user->balance);
		$this->getMessagesSuccess();
		return redirect()->back();
	}

	public function success($id)
	{
		$payIn = PayIn::find($id);
		if ($payIn && $payIn->pi_status == 3) {
			$this->getMessagesErrors();
			return redirect()->back();
		}

		if ($payIn->pi_status != 2)
			$flag = true;

		$payIn->pi_status   = PayIn::STATUS_SUCCESS;
		$payIn->pi_admin_id = get_data_user('admins');
		$payIn->save();

		if (isset($flag)) {
			$user          = User::find($payIn->pi_user_id);
			$user->balance += $payIn->pi_money;
			$user->save();

			$data = [
				'pi_user_id' => $user->id,
				'pi_money'   => $payIn->pi_money
			];

			$this->syncPayHistories($data, $id, $user->balance);
		}

		$this->getMessagesSuccess();
		return redirect()->back();
	}


}
