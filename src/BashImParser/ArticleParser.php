<?php

namespace App\BashImParser;

use Symfony\Component\DomCrawler\Crawler;

class ArticleParser
{
    static function fromHCrawlerNode(Crawler $node): Article
    {
        $article = new Article();

        $article->id = (int)$node->attr('data-quote');
        $article->body = strip_tags(str_ireplace(
            ['<br>', '<br/', '<br />'],
            chr(10),
            trim($node->filter('.quote__body')->html())
        ));
        $article->date = self::parseDate($node->filter('.quote__header_date')->text());
        $article->vote = (int) $node->filter('.quote__total')->text();

        return $article;
    }

    static private function parseDate(string $str) {
        return \DateTimeImmutable::createFromFormat('d#m#Y * H#i', trim($str));
    }
}
