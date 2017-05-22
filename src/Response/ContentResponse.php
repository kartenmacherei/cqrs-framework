<?php

namespace Kartenmacherei\CQRSFramework\Response;

use Kartenmacherei\CQRSFramework\Response\Content\Content;
use Kartenmacherei\CQRSFramework\Response\Header\StatusHeader;

class ContentResponse extends AbstractResponse
{
    /**
     * @var StatusHeader
     */
    private $statusHeader;

    /**
     * @var Content
     */
    private $content;

    /**
     * @param StatusHeader $statusHeader
     * @param Content $content
     */
    public function __construct(StatusHeader $statusHeader, Content $content)
    {
        $this->statusHeader = $statusHeader;
        $this->content      = $content;
    }

    protected function doSend()
    {
        $this->statusHeader->send();
        $this->content->send();
    }

    /**
     * @return StatusHeader
     */
    public function getStatusHeader()
    {
        return $this->statusHeader;
    }

    /**
     * @return Content
     */
    public function getContent()
    {
        return $this->content;
    }
}
