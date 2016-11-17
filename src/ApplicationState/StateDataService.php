<?php

namespace Kartenmacherei\HttpFramework\ApplicationState;

use Kartenmacherei\HttpFramework\Library\SessionId;

class StateDataService
{
    /**
     * @var StateDataFileLoader
     */
    private $stateDataFileLoader;

    /**
     * @var StateDataFileWriter
     */
    private $stateDataFileWriter;

    /**
     * @param StateDataFileLoader $stateDataFileLoader
     * @param StateDataFileWriter $stateDataFileWriter
     */
    public function __construct(StateDataFileLoader $stateDataFileLoader, StateDataFileWriter $stateDataFileWriter)
    {
        $this->stateDataFileLoader = $stateDataFileLoader;
        $this->stateDataFileWriter = $stateDataFileWriter;
    }

    /**
     * @param SessionId $sessionId
     * @return StateData
     */
    public function loadData(SessionId $sessionId) : StateData
    {
        return $this->stateDataFileLoader->load($sessionId);
    }

    /**
     * @param StateData $stateData
     */
    public function save(StateData $stateData)
    {
        $this->stateDataFileWriter->write($stateData);
    }

}