<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
	use Notifiable, HasRoles;

	const STATUS_ACTIVE = 1;
	const STATUS_BLOCK = - 1;

	protected $guard_name = 'admins';
	protected $guarded = [];
	protected $hidden = [
		'password', 'remember_token',
	];

	public $status_admin = [
		self::STATUS_ACTIVE => [
			'name' => 'Active',
			'class' => 'primary'
		],
		self::STATUS_BLOCK => [
			'name' => 'Block',
			'class' => 'warning'
		],
	];

	public function getStatus()
	{
		return \Arr::get($this->status_admin, $this->status,"[N\A]");
	}
}
