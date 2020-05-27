<?php


namespace Core\Test\Http\Controllers;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Plugins\ConvertWordPdf\PdfConvertServices;

class ConvertPdfToHtml extends Controller
{
	public function index()
	{
		return view('test::convert.pdf_to_html');
	}

	public function store(Request $request)
	{
		$file = $request->file;
		$pdf = new PdfConvertServices($file);
		$html = $pdf->initPdf()->getHtml();
		return view('test::convert.render_html',compact('html'));
	}
}