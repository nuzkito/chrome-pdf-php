# ChromePdf

Simple wrapper to convert HTML to PDF using Google Chrome in headless mode.

## Install

```
composer require nuzkito/chrome-html-to-pdf
```

Requires Chrome 59 installed in Linux and Mac, and Chrome 60 in Windows.

To install Chrome in a Linux server based in Debian:
```bash
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt-get install -f
```

In other cases download it in https://www.google.es/chrome/browser/desktop/index.html

## Use
```php
<?php

use Nuzkito\ChromePdf\ChromePdf;

// By default it will search for Chrome in the default path in each OS,
$pdf = new ChromePdf();
// but you need it, you can specify the route to the binary.
$pdf = new ChromePdf('/path/to/google-chrome');

// Route when PDF will be saved.
$pdf->output('/path/to/result.pdf');

// You can generate a PDF from a url
$pdf->generateFromUrl('http://google.es');
// ... from a HTML file
$pdf->generateFromFile('/path/to/html/document.html');
// ... or pass a string containing the HTML.
$pdf->generateFromHtml('<h1>Hello world!</h1>');
```

## Tests

You need to install `pdftotext` to execute the automated tests:

```bash
sudo apt-get install poppler-utils
```

And then, execute `vendor/bin/phpunit`.

### Config
If you need to specify the path to Chrome, you can create a `config.php` file with this content:

```php
<?php

$_ENV['chrome-executable'] = '/path/to/google-chrome';
```
