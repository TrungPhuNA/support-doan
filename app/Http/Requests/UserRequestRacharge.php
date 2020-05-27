<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestRacharge extends FormRequest
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

	public function rules()
	{
		return [
			'money' => 'required:max:10',
			'meta'  => 'required|max:400'
		];
	}

	public function messages()
	{
		return [
			'money.required' => 'Dữ liệu không được để trống',
			'money.max'      => 'Số tiền yêu cầu nạp quá dài',
			'meta.required'  => 'Dữ liệu không được để trống',
			'meta.max'       => 'Mô tả không được quá 400 ký tự'
		];
	}
}
