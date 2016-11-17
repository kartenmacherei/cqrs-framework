<?php

namespace Kartenmacherei\CQRSFramework;

use Kartenmacherei\CQRSFramework\Library\Exception\InvalidConfigurationException;

class CQRSConfig
{
    /**
     * @var array
     */
    private $config = [
        'tmpStateDataDirectory' => '../src/tmpStateData'
    ];

    /**
     * @param array $configuration
     */
    public function __construct($configuration = [])
    {
        $this->config = array_merge($this->config, $configuration);
    }

    /**
     * @return mixed
     */
    public function tmpStateDataDirectory()
    {
        $this->ensureTmpStateDataDirectory();

        return $this->config['tmpStateDataDirectory'];
    }


    private function ensureTmpStateDataDirectory()
    {
        if (!isset($this->config['tmpStateDataDirectory'])) {
            throw new InvalidConfigurationException('Invalid Configuration: temporary state data directory not found');
        }
    }
}