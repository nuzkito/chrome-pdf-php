<?php

namespace Nuzkito\ChromePdf;

use Exception;

class ChromePdf
{
    protected $binary;
    protected $output;

    public function __construct($binary = 'google-chrome')
    {
        if (!$this->isInstalled($binary)) {
            throw new Exception('Chrome is not installed (or you are not providing the correct path).');
        }

        $this->binary = $binary;
    }

    protected function isInstalled($binary)
    {
        $version = shell_exec(escapeshellcmd($binary) . ' --version 2>&1');

        return substr($version, 0, 13) === 'Google Chrome' || substr($version, 0, 8) === 'Chromium';
    }

    public function output($output)
    {
        $this->output = $output;

        return $this;
    }

    public function generateFromUrl($url)
    {
        $command = sprintf(
            '%s --headless --disable-gpu --print-to-pdf=%s %s 2>&1',
            escapeshellcmd($this->binary),
            escapeshellarg($this->output),
            escapeshellarg($url)
        );

        exec($command);
    }

    public function generateFromFile($file)
    {
        $this->generateFromUrl('file://' . $file);
    }

    public function generateFromHtml($html)
    {
        $this->generateFromUrl('data:text/html,' . rawurlencode($html));
    }
}
