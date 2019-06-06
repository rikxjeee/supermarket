<?php
require 'vendor/autoload.php';
use Supermarket\Supermarket;
$content = file_get_contents('./index.html');
$app = new Supermarket();
echo str_replace('%CONTENT%', $app->getContent(), $content);