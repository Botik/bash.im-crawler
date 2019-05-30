<?php

namespace App;

require '../vendor/autoload.php';

$parser = new BashImParser\Parser();
$parser->parseMainPage();

echo 1;
