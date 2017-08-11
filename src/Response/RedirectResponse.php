<?php

namespace Kartenmacherei\CQRSFramework\Response;

use Kartenmacherei\CQRSFramework\Library\File\Path;
use Kartenmacherei\CQRSFramework\Response\Header\TemporaryRedirectHeader;

class RedirectResponse extends AbstractResponse
{
    /**
     * @var Path
     */
    private $path;

    /**
     * @param Path $path
     */
    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    protected function doSend()
    {
        $redirectHeader = new TemporaryRedirectHeader($this->path);

        $redirectHeader->send();
    }

    /**
     * @return Path
     */
    public function path()
    {
        return $this->path;
    }
}
