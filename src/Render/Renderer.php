<?php

namespace Kartenmacherei\HttpFramework\Render;

use Kartenmacherei\HttpFramework\Library\File\FileName;

interface Renderer
{
    /**
     * @param FileName $filename
     * @param array $data
     * @return string
     */
    public function render(FileName $filename, $data = []) : string;
}