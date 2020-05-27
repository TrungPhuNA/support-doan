<?php


namespace Core\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Campaign;

class AdminCampaignController extends Controller
{
	public function index()
	{
		$campaigns = Campaign::orderByDesc('id')
			->paginate(20);

		$viewData = [
			'campaigns' => $campaigns
		];

		return view('admin::campaign.index', $viewData);
	}
}