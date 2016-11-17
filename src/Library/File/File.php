<?php

namespace Kartenmacherei\CQRSFramework\Library\File;

class File
{
    /**
     * @var Directory
     */
    private $directory;

    /**
     * @var FileName
     */
    private $fileName;

    /**
     * @param Directory $directory
     * @param FileName $fileName
     */
    public function __construct(Directory $directory, FileName $fileName)
    {
        $this->directory = $directory;
        $this->fileName  = $fileName;
    }

    /**
     * @return Directory
     */
    public function directory()
    {
        return $this->directory;
    }

    /**
     * @return FileName
     */
    public function fileName()
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function fullFilePath()
    {
        return $this->directory() . $this->fileName();
    }

    /**
     * @return bool
     */
    public function exists()
    {
        return file_exists($this->fullFilePath());
    }

    /**
     * @return string
     */
    public function contents()
    {
        return file_get_contents($this->fullFilePath());
    }

    /**
     * @param $fileContents
     * @return bool
     */
    public function save($fileContents) : bool
    {
        return file_put_contents($this->fullFilePath(), $fileContents);
    }

    public function unlink()
    {
        unlink($this->fullFilePath());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->directory() . $this->fileName();
    }
}
