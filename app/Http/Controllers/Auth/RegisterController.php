<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRegister;
use App\Jobs\Account\VeryAccountJob;
use App\Models\Notification;
use App\Providers\RouteServiceProvider;
use App\Services\Notifications\NotificationService;
use App\User;
use Hashids\Hashids;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Support\Facades\Mail;
use Pusher\Pusher;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getFormRegister()
    {
        $optionsMeta = [
            'meta_title'       => 'Đăng ký',
        ];
        $metaSeo     = RenderMetaSeo::MetaSeo($optionsMeta);

        return view('auth.register', compact('metaSeo'));
    }

    public function postRegister(RequestRegister $request)
    {
        $data               = $request->except("_token","utm_source","ref_id");
        $data['password']   =  Hash::make($data['password']);
        $data['created_at'] = Carbon::now();
        $data['status'] = User::STATUS_DEFAULT;

        $user = User::create($data);

        if ($user) {

			$hashids = new Hashids('', 50, config('setting._token'));
			$slug   = $hashids->encode($user->id);
			$user->slug = $slug;
			$user->save();

			if ($parentID = $request->ref_id) {
				$presenter =  $this->checkPresenterById($parentID);
				if ($presenter) {
					$user->parent_id = $presenter->id;
					$user->save();
					$presenter->total_friend += 1;
					$presenter->save();
				}
			}
			if ($request->utm_source)
			{
				$dataMeta['utm_source'] = $request->utm_source;
				$user->meta = json_encode($dataMeta);
				$user->save();
			}

            \Session::flash('toastr', [
                'type'    => 'success',
                'message' => 'Đăng ký thành công. Mời bạn kiểm tra email để xác nhận tài khoản'
            ]);

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
				$pusher->trigger('NotificationRegisterEvent', 'send-message', $user);
				$html = "Thành viên  <b>".$user->name."</b> vừa đăng ký tài khoản";
				NotificationService::saveNotify($html, Notification::TYPE_REGISTER);
			}catch (\Exception $exception){
				\Log::error("pusher and notify ". $exception->getMessage());
			}

			dispatch(new VeryAccountJob($user))
				->onQueue('very-account')
				->delay(Carbon::now()->addMinutes(1));

            if (\Auth::attempt(['email' => $request->email,'password' => $request->password]))
				return redirect()->to($this->redirectTo('login_redirect_to'));

            return redirect()->route('get.login');
        }

        return redirect()->back();
    }

    protected function checkPresenterById($id)
	{
		return User::find($id);
	}
}
