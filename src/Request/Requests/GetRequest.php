<?php
namespace Kartenmacherei\HttpFramework\Request;

class GetRequest extends Request
{
    public function isGetRequest()
    {
        return true;
    }
}
