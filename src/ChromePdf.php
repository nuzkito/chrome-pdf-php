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

    public function generateFromFile($file)
    {
        $exec = "{$this->binary} --headless --disable-gpu ";
        $exec .= "--print-to-pdf={$this->output} ";
        $exec .= "file://{$file} 2>&1";
        exec($exec);
    }

    public function generateFromHtml($html)
    {
        $html = rawurlencode($html);

        $exec = "{$this->binary} --headless --disable-gpu ";
        $exec .= "--print-to-pdf={$this->output} ";
        $exec .= "data:text/html,{$html} 2>&1";
        exec($exec);
    }
}
