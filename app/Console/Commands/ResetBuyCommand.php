<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetBuyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-buy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset buy';

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
        $this->info("[Reset Data Buy]");
        \DB::table('users')
			->update(['balance' => 0]);

        \DB::table('pay_histories')->truncate();
        \DB::table('pay_ins')->truncate();
        \DB::table('pay_outs')->truncate();
        \DB::table('pay_outs')->truncate();
        \DB::table('transactions')->truncate();
    }
}
