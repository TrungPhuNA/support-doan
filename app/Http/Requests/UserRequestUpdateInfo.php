<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestUpdateInfo extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = get_data_user('web');
		return [
			'email' => 'bail|required|email|unique:users,email,' . $id,
			'phone' => 'bail|required|min:10|regex:/(0[0-9]*)/|max:11'
		];
	}

	public function messages()
	{
		return [
			'email.required' => 'Dữ liệu không được để trống',
			'email.unique'   => 'Email đã tồn tại',
			'phone.required' => 'Dữ liệu không được để trống',
			'phone.regex'    => 'Số điện thoại chỉ bao gồm số',
			'phone.min'      => 'Số điện thoại quá ngắn',
			'phone.max'      => 'Số điện thoại quá dài',
		];
	}
}
