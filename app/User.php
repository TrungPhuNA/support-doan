<?php

namespace App;

use App\Models\SocialAccount;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
	use Notifiable;

	const STATUS_BLOCK             = -1;
	const STATUS_DEFAULT           = 1;
	const STATUS_PROCESSING_VERIFY = 2;
	const STATUS_ACTIVE            = 3;


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'address', 'avatar', 'balance', 'phone', 'slug', 'status','total_friend',
		'parent_id','meta'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public $status_user = [
		self::STATUS_DEFAULT           => [
			'name'  => 'Default',
			'class' => 'default'
		],
		self::STATUS_ACTIVE            => [
			'name'  => 'Active',
			'class' => 'success'
		],
		self::STATUS_PROCESSING_VERIFY => [
			'name'  => 'Processing Verify',
			'class' => 'primary'
		],
		self::STATUS_BLOCK             => [
			'name'  => 'Block',
			'class' => 'warning'
		],
	];

	public function getStatus()
	{
		return Arr::get($this->status_user, $this->status, "[N\A]");
	}

	public function social()
	{
		return $this->hasOne(SocialAccount::class, 'user_id');
	}

	public function presenter()
	{
		return $this->belongsTo(User::class,'parent_id');
	}
}
