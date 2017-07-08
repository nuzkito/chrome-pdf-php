<?php

require 'vendor/autoload.php';

if (file_exists('config.php')) {
    require 'config.php';
}

if (!isset($_ENV['chrome-executable'])) {
    $_ENV['chrome-executable'] = null;
}
