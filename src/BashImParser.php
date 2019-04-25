<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;

class BashImParser
{
    private $html;
    private $dom;

    public $articleCount;

    /**
     * ArticleHmlParser constructor.
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
        $this->dom = new Crawler($html);
    }

    public function parse()
    {
        $this->parseArticleCount();
    }

    /**
     * @return int
     */
    public function parseArticleCount()
    {
        return $this->articleCount = (int)$this->dom
            ->filter('.quote__body')
            ->first()
            ->children()
            ->first()
            ->filter('b')
            ->text();
    }

    /**
     * @return Crawler
     */
    public function parseArticles()
    {
        return $this->dom->filter('.quotes')->first();
    }

    public function parseArticle()
    {

    }
}
