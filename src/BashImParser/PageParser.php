<?php

namespace App\BashImParser;

use Symfony\Component\DomCrawler\Crawler;

class PageParser
{
    private $html;
    private $dom;

    /**
     * ArticleHmlParser constructor.
     * @param string $html
     */
    public function __construct(string $html)
    {
        $this->html = $html;
        $this->dom = new Crawler($html);
    }

    /**
     * @return int
     */
    public function parseArticleCount()
    {
        return (int) $this->dom
            ->filter('.quote__body')
            ->first()
            ->children()
            ->first()
            ->filter('b')
            ->text();
    }

    /**
     * @return int
     */
    public function parseCurrentPageId()
    {
        return (int) $this->dom
            ->filter('.quotes')
            ->attr('data-page');
    }

    /**
     * @return \SplFixedArray
     */
    public function parseArticles()
    {
        $quotes = $this->dom->filter('.quotes')->children('.quote');
        $articles = new \SplFixedArray(count($quotes));

        $quotes->each(function (Crawler $node, int $i) use ($articles) {
            $articles[$i] = ArticleParser::fromHCrawlerNode($node);
        });

        return $articles;
    }
}
