<?php
namespace Kartenmacherei\CQRSFramework\Request;

class PostRequest extends Request
{
    public function isPostRequest()
    {
        return true;
    }
}
