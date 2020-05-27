<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequestDocument extends FormRequest
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
			'dcm_name'        => 'required|max:190|min:3|unique:documents,dcm_name,' . $this->id,
			'dcm_price'       => 'required',
//			'dcm_number'      => 'required',
			'dcm_category_id' => 'required',
		];
	}

	public function messages()
	{
		return [
			'dcm_name.required'        => 'Dữ liệu không được để trống',
			'dcm_name.unique'          => 'Dữ liệu đã tồn tại',
			'dcm_name.max'             => 'Dữ liệu không quá 190 ký tự',
			'dcm_name.min'             => 'Dữ liệu phải nhiều hơn 3 ký tự',
			'dcm_price.required'       => 'Dữ liệu không được để trống',
			'dcm_category_id.required' => 'Dữ liệu không được để trống',
//			'dcm_number.required'      => 'Dữ liệu không được để trống',
		];
	}
}
