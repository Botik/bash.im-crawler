<?php

namespace App\BashImParser;

use Symfony\Component\HttpClient\CurlHttpClient;

class Parser
{
    const URL = 'https://bash.im/';

    /**
     * @var int
     */
    public $articleCount;

    /**
     * @var int
     */
    public $lastPageId;

    /**
     * @var Page[]
     */
    public $pages = [];

    /**
     * @var CurlHttpClient
     */
    private $client;

    public function __construct()
    {
        $this->client = new CurlHttpClient(['verify_peer' => false]);
    }

    /**
     * @return Page
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function parseMainPage(): Page
    {
        $respose = $this->client->request('GET', self::URL);
        $page = PageParser::fromHtml($respose->getContent());
        $this->articleCount = PageParser::parseArticleCount($page);
        $this->lastPageId = $page->id;
        $page->dom = null;

        return $this->pages[$page->id] = $page;
    }

    /**
     * @param int $id
     *
     * @return Page
     *
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function parseNumPage(int $id): Page
    {
        $response = $this->client->request('GET', self::URL.'index/'.$id);
        $page = PageParser::fromHtml($response->getContent());
        $page->dom = null;

        return $this->pages[$page->id] = $page;
    }
}
