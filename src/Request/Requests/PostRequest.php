<?php
namespace Kartenmacherei\HttpFramework\Request;

class PostRequest extends Request
{
    public function isPostRequest()
    {
        return true;
    }
}
