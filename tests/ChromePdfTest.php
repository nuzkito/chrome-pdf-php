<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Nuzkito\ChromePdf\ChromePdf;

class ChromePdfTest extends TestCase
{
    protected $pdfFile = 'assets/result.pdf';

    protected function tearDown()
    {
        unlink(__DIR__ . '/' . $this->pdfFile);
    }

    protected function getTextFromPdf()
    {
        return \Spatie\PdfToText\Pdf::getText(__DIR__ . '/' . $this->pdfFile);
    }

    /** @test */
    function generate_pdf_from_html_file()
    {
        $pdf = new ChromePdf('google-chrome');
        $pdf->output(__DIR__ . '/' . $this->pdfFile);
        $pdf->generateFromFile(__DIR__ . '/assets/index.html');

        $content = $this->getTextFromPdf();

        $this->assertContains('Lorem ipsum dolor sit amet', $content);
    }
}
