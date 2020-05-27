<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TruncateDBCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'truncate:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'truncate db';

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
		\DB::table('transactions')->truncate();
		\DB::table('users')
			->update(['balance' => 0]);

		\DB::table('pay_histories')->truncate();
		\DB::table('pay_ins')->truncate();
		\DB::table('pay_outs')->truncate();
		\DB::table('pay_outs')->truncate();
		\DB::table('documents')->truncate();
		\DB::table('categories')->truncate();
		\DB::table('combo_document_multiple')->truncate();
		\DB::table('combo_documents')->truncate();
    }
}
