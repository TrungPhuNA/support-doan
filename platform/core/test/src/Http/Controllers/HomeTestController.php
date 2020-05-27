<?php

namespace Core\Test\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeTestController extends Controller
{
	public function index()
	{
		return view('test::index');
	}
}