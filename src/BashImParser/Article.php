<?php

namespace App\BashImParser;

class Article
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $vote;

    /**
     * @var \DateTimeImmutable
     */
    public $date;
}
