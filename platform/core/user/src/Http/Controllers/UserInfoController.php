<?php

namespace Core\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Core\MetaSeo\Http\Controllers\RenderMetaSeo;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequestUpdateInfo;
use App\User;

class UserInfoController extends Controller
{
    public function updateInfo()
    {
		$optionsMeta             = [
			'meta_title'       => 'Cập nhật tài khoản',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_image'       => '',
			'meta_robots'      => ''
		];
		$metaSeo                 = RenderMetaSeo::MetaSeo($optionsMeta);

        return view('user::pages.update_info',compact('metaSeo'));
    }

    public function saveUpdateInfo(UserRequestUpdateInfo $request)
    {
        $data = $request->except('_token','avatar');
        $user = User::find(\Auth::id());

        if ($request->avatar) {
            $image = upload_image('avatar');
            if ($image['code'] == 1)
                $data['avatar'] = $image['name'];
        }

        $user->update($data);

        \Session::flash('toastr', [
            'type'    => 'success',
            'message' => 'Cập nhật thành công'
        ]);

        return redirect()->back();
    }

    public function updateInfoAjax(UserRequestUpdateInfo $request, $id)
	{
		if ($request->ajax())
		{
			$user = User::findOrFail(get_data_user('web'));
			$user->phone = $request->phone;
			$user->email = $request->email;
			$user->save();

			\Log::info("ID update ". $id . ' -- phone '. $request->phone);
			return response()->json([
				'code' => 200
			]);
		}
	}
}
