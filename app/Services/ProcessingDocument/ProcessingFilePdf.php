<?php


namespace App\Services\ProcessingDocument;


use App\Core\Alert\CliEcho;
use App\Core\CustomerPackage\Pdf;
use Illuminate\Support\Facades\Log;

class ProcessingFilePdf
{
	protected $path_file;
	protected $result = [];

	protected $optionsPdf = [
		'pdftohtml_path' => '/usr/local/bin/pdftohtml',
		'pdfinfo_path'   => '/usr/local/bin/pdfinfo',
		'generate'       => [
			'zoom'     => 1.5,
			'noFrames' => true,
		]
	];

	public function __construct($path_file)
	{
		$this->path_file = $path_file;
		$this->init();
	}

	public function init()
	{
		CliEcho::warningnl("-- [File name]" . $this->path_file);
		$pdf = $this->configPdf($this->path_file);

		//1. Count số page
		$this->result['count_page'] = $pdf->countPages();

		//2. Tạo thumbar
		$this->initThumbnailDocument();

//		dd($this->result);
	}

	protected function initThumbnailDocument()
	{
		$path          = public_path(pare_url_file($this->path_file));
		$fileName      = explode('.', $this->path_file);
		$nameThumbnail = $fileName[0] ?? $this->path_file;
		$pdf           = new Pdf($path);
		$pdf->setPage(1)
			->setOutputFormat('png')
			->saveImage(public_path(pare_url_file($nameThumbnail . ".png")));

		$this->result['thumbnail'] = $nameThumbnail . ".png";
	}

	protected function configPdf($path, $options = [])
	{
		if (empty($options))
			$options = $this->optionsPdf;

		return new \TonchikTm\PdfToHtml\Pdf(public_path(pare_url_file($path)), $options);
	}
}