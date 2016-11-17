<?php

namespace Kartenmacherei\CQRSFramework\Render;

use Kartenmacherei\CQRSFramework\Library\File\FileName;

interface Renderer
{
    /**
     * @param FileName $filename
     * @param array $data
     * @return string
     */
    public function render(FileName $filename, $data = []) : string;
}