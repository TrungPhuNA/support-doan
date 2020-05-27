<?php


namespace App\Services\Campaign;


use App\Models\Campaign;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProcessingCampaignByUrl
{
	public function init()
	{
		$utm_source  = request()->get('utm_source');
		$ref_id      = request()->get('ref_id');
		$slug_source = Str::slug($utm_source);

		if (!$slug_source)  return;

		$campaign = $this->checkExistsUrlSource($slug_source);

		if (!$campaign) {
			$campaign          = Campaign::create([
				'cp_source'      => $utm_source,
				'cp_source_slug' => $slug_source,
				'cp_url'         => request()->url(),
				'created_at'     => Carbon::now(),
				'cp_ip'          => request()->ip()
			]);
			$campaign->cp_view += 1;
			$campaign->save();
		}

		$user = $this->checkUserByRefId($ref_id);
	}

	/**
	 * @param $slug_source
	 * @return mixed
	 */
	protected function checkExistsUrlSource($slug_source)
	{
		$campaign = Campaign::where([
			'cp_source_slug' => $slug_source,
			'cp_ip'          => request()->ip(),
			'cp_url'         => request()->url()
		])->first();

		return $campaign;
	}

	protected function checkUserByRefId($userID)
	{
		return User::find($userID);
	}
}