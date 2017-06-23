# ChromePdf

Simple wrapper to generate PDF using Google Chrome in headless mode.

Requires Chrome 59 installed. To install Chrome in a Linux Debian:
```
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
sudo apt-get install -f
```

## Use
```
<?php

// By default expects `google-chrome` installed in the system, but you can specify the route to the binary, or other binary like `chromium`.
$pdf = new ChromePdf('/path/to/google-chrome');

// Route when PDF will be saved.
$pdf->output('/path/to/result.pdf');

// You can generate a PDF from a HTML file
$pdf->generateFromFile('/path/to/html/document.html');
// or pass a string with the HTML
$pdf->generateFromHtml('<h1>Hello world!</h1>');
```

## Tests

You need to install `pdftotext` to execute the automated tests:

```
sudo apt-get install poppler-utils
```

And then, execute `vendor/bin/phpunit`.

### Config
By default, tests will search for an executable called `google-chrome`. If you need to specify the path, you can create a `config.php` file with this content:

```
<?php

$_ENV['chrome-executable'] = '/path/to/google-chrome';
```
