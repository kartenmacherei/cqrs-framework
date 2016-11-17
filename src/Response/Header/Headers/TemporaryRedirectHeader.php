<?php
namespace Kartenmacherei\HttpFramework;

use Kartenmacherei\HttpFramework\Library\File\Path;
use Kartenmacherei\HttpFramework\Response\Header\Header;

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
