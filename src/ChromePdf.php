<?php

namespace Nuzkito\ChromePdf;

use Exception;

class ChromePdf
{
    protected $binary;
    protected $output;

    public function __construct($binary = null)
    {
        $this->binary = $this->getBinaryPath($binary);

        if (!$this->isInstalled($this->binary)) {
            throw new Exception('Chrome is not installed (or you are not providing the correct path).');
        }
    }

    protected function getBinaryPath($binary = null)
    {
        if ($binary) {
            return $binary;
        }

        if (PHP_OS === 'WINNT') {
            return 'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe';
        } elseif (PHP_OS === 'Darwin') {
            return '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
        }

        return 'google-chrome';
    }

    protected function isInstalled($binary)
    {
        $version = shell_exec(escapeshellarg($binary) . ' --version 2>&1');

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
            escapeshellarg($this->binary),
            escapeshellarg($this->output),
            escapeshellarg($url)
        );

        exec($command);
    }

    public function generateFromFile($file)
    {
        if ($file[0] !== '/') {
            $file = getcwd() . '/' . $file;
        }

        $this->generateFromUrl('file://' . $file);
    }

    public function generateFromHtml($html)
    {
        $this->generateFromUrl('data:text/html,' . rawurlencode($html));
    }
}
