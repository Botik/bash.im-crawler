<?php

namespace App\BashImParser;

class Parser
{
    const URL = 'https://bash.im/';

    /**
     * @var int
     */
    private $articleCount;

    /**
     * @var int
     */
    private $lastPageId;

    /**
     * @var Article[]
     */
    private $articles = [];

    public function parseMainPage()
    {
        $page = new PageParser(file_get_contents('https://bash.im/'));
        $this->articleCount = $page->parseArticleCount();
        $this->lastPageId = $page->parseCurrentPageId();
        array_merge($this->articles, $page->parseArticles());
    }
}
