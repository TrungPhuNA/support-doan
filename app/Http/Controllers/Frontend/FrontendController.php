<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Campaign\ProcessingCampaignByUrl;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Attribute;

class FrontendController extends Controller
{
	public function __construct()
	{
//		(new ProcessingCampaignByUrl())->init();
	}
}
