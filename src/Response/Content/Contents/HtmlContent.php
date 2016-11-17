<?php

namespace Kartenmacherei\CQRSFramework\Response\Content;

class HtmlContent implements Content
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    public function send()
    {
        header('Content-Type: text/html; charset=utf-8');

        print $this->content;
    }
}
