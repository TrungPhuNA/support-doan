<?php
namespace Core\Test\Http\Controllers;

use App\Http\Controllers\Controller;
use \ConvertApi\ConvertApi;

class ConvertFileController extends Controller
{
	protected $input = 'hop-dong-dai-ly-doc-quyen.doc';
	protected $out = 'hop-dong-dai-ly-doc-quyen.pdf';
	public function convertWordToPdf()
	{
		$this->callAPi();
	}

	public function callConvert()
	{
		dump(phpinfo());
		ini_set("com.allow_dcom","true");
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		// set it to 1 to see the MS Word window (the actual opening of the document)
		$word->Visible = 0;
		// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
		$word->DisplayAlerts = 0;
		// open the word 2007-2013 document
		$word->Documents->Open(realpath('hop-dong-dai-ly-doc-quyen.docx'));
		// save it as word 2003
		$word->ActiveDocument->SaveAs(realpath('hop-dong-dai-ly-doc-quyen.doc'));
		// convert word 2007-2013 to PDF
		$pdf = realpath('hop-dong-dai-ly-doc-quyen.pdf');
		dump($pdf);
		$word->ActiveDocument->ExportAsFixedFormat($pdf, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
		// quit the Word process
		$word->Quit(false);
		// clean up
		unset($word);
		dd("12121");
	}

	public function callAPi()
	{
		dd('111');
		ConvertApi::setApiSecret('ajADWp9e2LEuU65m');
		$result = ConvertApi::convert('png', [
			'File' => public_path($this->input),
			'PageRange' => '1-10',
		], 'doc');


		dd($result);
		$result->saveFiles(public_path($this->out));
	}
}