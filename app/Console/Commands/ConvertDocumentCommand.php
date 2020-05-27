<?php

namespace App\Console\Commands;

use App\Models\Document;
use Illuminate\Console\Command;

class ConvertDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Document';

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
        $documents = Document::select('id','dcm_file')
			->get();
        foreach ($documents as $document)
		{
			$this->info("ID: ". $document->id);
			$file_pdf = str_replace($document->dcm_ext, 'pdf',$document->dcm_file);
			\DB::table('documents')->where('id',$document->id)
				->update([
					'dcm_file_preview' => $file_pdf
				]);
		}
    }





}
