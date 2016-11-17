<?php


namespace Kartenmacherei\HttpFramework\ApplicationState;


use Kartenmacherei\HttpFramework\Library\File\Directory;
use Kartenmacherei\HttpFramework\Library\File\FileName;
use Kartenmacherei\HttpFramework\Library\SessionId;
use UnexpectedValueException;

class StateDataFileLoader
{
    /**
     * @var Directory
     */
    private $directory;

    /**
     * @param Directory $directory
     */
    public function __construct(Directory $directory)
    {
        $this->directory = $directory;
    }

    public function load(SessionId $sessionId)
    {
        $sessionFileName = $sessionId->asString();
        $fileName = new FileName($sessionFileName, 'state');

        $file = $this->directory->file($fileName);

        if (!$file->exists()) {
            return new StateData($sessionId);
        }

        $serializedData = $file->contents();
        $result = unserialize($serializedData);

        if (!$result instanceof StateData) {
            throw new UnexpectedValueException;
        }

        return $result;
    }
}