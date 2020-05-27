<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\User;
use Hashids\Hashids;
use Illuminate\Console\Command;

class RenderHashSlugByUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:render-slug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'render Slug By User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("[init render slug user]");
//		$hashids = new Hashids('', 20, config('setting._token')); // admin
		$hashids    = new Hashids('', 50, config('setting._token'));
		$users = User::all();
		foreach ($users as $user)
		{
			$slug   = $hashids->encode($user->id);
			$this->info("[-- Slug: ]". $slug);
			\DB::table('users')->where('id', $user->id)
				->update([
					'slug' => $slug
				]);

		}
    }
}
