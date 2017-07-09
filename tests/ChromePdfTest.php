<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Nuzkito\ChromePdf\ChromePdf;
use Exception;

class ChromePdfTest extends TestCase
{
    protected $pdfFile = 'assets/result.pdf';
    protected $chromeExecutable;

    protected function setUp()
    {
        $this->chromeExecutable = $_ENV['chrome-executable'];
    }

    protected function tearDown()
    {
        if (file_exists(__DIR__ . '/' . $this->pdfFile)) {
            unlink(__DIR__ . '/' . $this->pdfFile);
        }
    }

    protected function getTextFromPdf()
    {
        return \Spatie\PdfToText\Pdf::getText(__DIR__ . '/' . $this->pdfFile);
    }

    /** @test */
    function throws_an_error_if_chrome_is_not_found()
    {
        $this->expectException(Exception::class);

        $pdf = new ChromePdf('this-is-not-chrome');
    }

    /** @test */
    function generate_pdf_from_html_file_using_absolute_path()
    {
        $pdf = new ChromePdf($this->chromeExecutable);
        $pdf->output(__DIR__ . '/' . $this->pdfFile);
        $pdf->generateFromFile(__DIR__ . '/assets/index.html');

        $content = $this->getTextFromPdf();

        $this->assertContains('Lorem ipsum dolor sit amet', $content);
    }

    /** @test */
    function generate_pdf_from_html_file_using_relative_path()
    {
        $pdf = new ChromePdf($this->chromeExecutable);
        $pdf->output('tests/' . $this->pdfFile);
        $pdf->generateFromFile('tests/assets/index.html');

        $content = $this->getTextFromPdf();

        $this->assertContains('Lorem ipsum dolor sit amet', $content);
    }

    /** @test */
    function generate_pdf_from_html_string()
    {
        $html = file_get_contents(__DIR__ . '/assets/index.html');

        $pdf = new ChromePdf($this->chromeExecutable);
        $pdf->output(__DIR__ . '/' . $this->pdfFile);
        $pdf->generateFromHtml($html);

        $content = $this->getTextFromPdf();

        $this->assertContains('Lorem ipsum dolor sit amet', $content);
    }
}
