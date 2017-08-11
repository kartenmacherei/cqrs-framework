<?php
namespace Kartenmacherei\CQRSFramework\Response\Header;

use Kartenmacherei\CQRSFramework\Library\File\Path;
use Kartenmacherei\CQRSFramework\Response\Header\Header;

class TemporaryRedirectHeader implements Header
{
    /**
     * @var Path
     */
    private $path;

    public function __construct(Path $path)
    {
        $this->path = $path;
    }

    public function send()
    {
        header('Location: ' . $this->path->asString(), 302);
    }
}
