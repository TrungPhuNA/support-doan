<?php

namespace Core\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBaseController extends Controller
{
    public function getMessagesSuccess()
	{
		\Session::flash('toastr', [
			'type'    => 'success',
		]);
	}

	public function getMessagesErrors()
	{
		\Session::flash('toastr', [
			'type'    => 'error',
		]);
	}
}
