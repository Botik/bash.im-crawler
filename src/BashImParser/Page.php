<?php

namespace App\BashImParser;

use Symfony\Component\DomCrawler\Crawler;

class Page
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var Crawler
     */
    public $dom;

    /**
     * @var Article[]
     */
    public $articles = [];
}
