<?php


namespace Kartenmacherei\CQRSFramework\ApplicationState;


use Kartenmacherei\CQRSFramework\Library\File\Directory;
use Kartenmacherei\CQRSFramework\Library\File\FileName;
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

    public function load(StateData $stateData)
    {
        $sessionId = $stateData->sessionId()->asString();
        $fileName = new FileName($sessionId, 'state');

        $file = $this->directory->file($fileName);

        if (!$file->exists()) {
            return $stateData;
        }

        $serializedData = $file->contents();
        $stateData = unserialize($serializedData);

        if (!$stateData instanceof StateData) {
            throw new UnexpectedValueException;
        }

        return $stateData;
    }
}