<?php


namespace Kartenmacherei\CQRSFramework\Response\Content;



class IcsContent implements Content
{
    /**
     * @var string
     */
    private $content;

    function __construct($content)
    {
        $this->content = $content;
    }

    public function send()
    {
        header('Content-type: text/calendar; charset=utf-8');

        echo $this->content;
    }
}