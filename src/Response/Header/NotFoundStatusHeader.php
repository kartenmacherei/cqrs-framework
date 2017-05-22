<?php
namespace Kartenmacherei\CQRSFramework\Response\Header;

class NotFoundStatusHeader implements StatusHeader
{
    public function send()
    {
        header('HTTP/1.1 404 Not Found');
    }
}
