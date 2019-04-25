<?php

namespace App;

require '../vendor/autoload.php';

$parser = new BashImParser(file_get_contents('https://bash.im/'));

echo $parser->parseArticleCount();
