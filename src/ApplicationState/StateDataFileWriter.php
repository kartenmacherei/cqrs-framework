<?php

namespace Kartenmacherei\HttpFramework\ApplicationState;

use Kartenmacherei\HttpFramework\Library\File\Directory;
use Kartenmacherei\HttpFramework\Library\File\FileName;
use Kartenmacherei\HttpFramework\Library\SessionId;

class StateDataFileWriter
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

    /**
     * @param StateData $stateData
     */
    public function write(StateData $stateData)
    {
        $sessionId = $stateData->sessionId();

        $sessionFileName = $sessionId->asString();
        $fileName = new FileName($sessionFileName, 'state');

        $file = $this->directory->file($fileName);

        $this->synchronizeDataFile($sessionId);

        $serializedData = serialize($stateData);

        $file->save($serializedData);
    }

    /**
     * @param $sessionId
     */
    public function synchronizeDataFile(SessionId $sessionId)
    {
        if ($sessionId->asString() != $sessionId->getOriginalId()) {
            $originalFileName = new FileName($sessionId->getOriginalId(), 'state');
            $originalFile = $this->directory->file($originalFileName);

            if ($originalFile->exists()) {
                $originalFile->unlink();
            }
        }
    }
}