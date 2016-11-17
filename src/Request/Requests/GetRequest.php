<?php
namespace Kartenmacherei\CQRSFramework\Request;

class GetRequest extends Request
{
    public function isGetRequest()
    {
        return true;
    }
}
