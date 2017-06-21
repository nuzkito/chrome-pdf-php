<?php

namespace Nuzkito\ChromePdf;

class ChromePdf
{
    protected $binary;
    protected $output;

    public function __construct($binary = 'google-chrome')
    {
        $this->binary = $binary;
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
}
