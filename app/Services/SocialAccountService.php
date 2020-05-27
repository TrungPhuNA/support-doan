<?php

namespace App\Services;

use Hashids\Hashids;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\SocialAccount;
use App\User;
use Illuminate\Support\Facades\Hash;


class SocialAccountService
{
	public static function createOrGetUser(ProviderUser $providerUser, $social)
	{
		$account = SocialAccount::whereProvider($social)
			->whereProviderUserId($providerUser->getId())
			->first();


		if ($account) return $account->user;

		$email   = $providerUser->getEmail() ?? ($providerUser->getName() ?? $providerUser->getNickname());
		$account = new SocialAccount([
			'provider_user_id' => $providerUser->getId(),
			'provider'         => $social
		]);

		$user = User::whereEmail($email)->first();

		if (!$user) {

			$user = User::create([
				'email'    => $email,
				'name'     => $providerUser->getName(),
				'password' => Hash::make($email),
				'stauts'   => User::STATUS_DEFAULT
			]);

			$hashids    = new Hashids('', 50, config('setting._token'));
			$slug       = $hashids->encode($user->id);
			$user->slug = $slug;
			$user->save();
		}

		$account->user()->associate($user);
		$account->save();

		return $user;
	}
}