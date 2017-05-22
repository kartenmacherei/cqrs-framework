<?php

namespace Kartenmacherei\CQRSFramework\ApplicationState;

use Kartenmacherei\CQRSFramework\Library\SessionId;

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
     * @param StateData $stateData
     *
     * @return StateData
     */
    public function loadData(StateData $stateData) : StateData
    {
        return $this->stateDataFileLoader->load($stateData);
    }

    /**
     * @param StateData $stateData
     */
    public function save(StateData $stateData)
    {
        $this->stateDataFileWriter->write($stateData);
    }

}