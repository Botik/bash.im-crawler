<?php

namespace App\BashImParser;

use Symfony\Component\DomCrawler\Crawler;

abstract class PageParser
{
    /**
     * @param string $html
     *
     * @return Page
     */
    public static function fromHtml(string $html): Page
    {
        $page = new Page();
        $page->dom = new Crawler($html);
        self::parseCurrentPageId($page);
        self::parseArticles($page);

        return $page;
    }

    /**
     * @param Page $page
     *
     * @return int
     */
    public static function parseArticleCount(Page $page): int
    {
        return (int) $page->dom
            ->filter('.quote__body')
            ->first()
            ->children()
            ->first()
            ->filter('b')
            ->text();
    }

    /**
     * @param Page $page
     *
     * @return int
     */
    public static function parseCurrentPageId(Page $page): int
    {
        $page->id = (int) $page->dom
            ->filter('.quotes')
            ->attr('data-page');

        return $page->id;
    }

    /**
     * @param Page $page
     *
     * @return Article[]
     */
    public static function parseArticles(Page $page): array
    {
        $articles = [];

        foreach ($page->dom->filter('.quotes')
            ->children('.quote')
            ->each(function (Crawler $node) {
                return ArticleParser::fromHCrawlerNode($node);
            }) as $v) {
            $articles[$v->id] = $v;
        }

        return $page->articles = $articles;
    }
}
