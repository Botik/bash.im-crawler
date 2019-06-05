<?php

namespace App\BashImParser;

use Symfony\Component\DomCrawler\Crawler;

abstract class QuoteParser
{
    public static function fromHCrawlerNode(Crawler $node): Quote
    {
        $article = new Quote();

        $article->id = (int) $node->attr('data-quote');
        $node->filter('.quote__body')->children('div')->each(function (Crawler $node) {
            return false;
        });
        $body = explode(chr(10), trim($node->filter('.quote__body')->html()));

        foreach ($body as $k => $v) {
            $body[$k] = trim($v);
        }

        $article->body = strip_tags(str_ireplace(
            ['<br>', '<br/', '<br />'],
            chr(10),
            trim(htmlspecialchars_decode(implode(' ', $body)))
        ));
        $article->date = self::parseDate($node->filter('.quote__header_date')->text());
        $article->vote = (int) $node->filter('.quote__total')->text();

        return $article;
    }

    private static function parseDate(string $str)
    {
        return \DateTimeImmutable::createFromFormat('d#m#Y * H#i', trim($str));
    }
}
