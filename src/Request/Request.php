<?php
namespace Kartenmacherei\HttpFramework\Request;

use Kartenmacherei\HttpFramework\ApplicationState\StateData;
use Kartenmacherei\HttpFramework\Library\Exception\NotFoundInCollectionException;
use Kartenmacherei\HttpFramework\Library\File\Path;
use Kartenmacherei\HttpFramework\Library\Parameter\Parameter;
use Kartenmacherei\HttpFramework\Library\Parameter\ParameterCollection;
use Kartenmacherei\HttpFramework\Library\Parameter\ParameterIdentifier;
use Kartenmacherei\HttpFramework\Library\SessionId;
use RuntimeException;

abstract class Request
{
    /**
     * @var Path
     */
    private $path;

    /**
     * @var ParameterCollection
     */
    private $parameters;

    /**
     * @var SessionId
     */
    private $sessionId;


    /**
     * @var StateData
     */
    private $stateData;

    /**
     * @var ParameterCollection
     */
    private $cookies;

    /**
     * @return Request
     */
    public static function fromSuperGlobals()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                return new GetRequest(
                    new Path($_SERVER['REQUEST_URI']),
                    ParameterCollection::fromArray($_GET),
                    ParameterCollection::fromArray($_COOKIE)
                );
                break;

            case 'POST':
                return new PostRequest(
                    new Path($_SERVER['REQUEST_URI']),
                    ParameterCollection::fromArray($_POST),
                    ParameterCollection::fromArray($_COOKIE)
                );
                break;

            default:
                throw new RuntimeException;
        }
    }

    /**
     * @param Path                $path
     * @param ParameterCollection $parameters
     * @param ParameterCollection $cookies
     */
    public function __construct(Path $path, ParameterCollection $parameters, ParameterCollection $cookies)
    {
        $this->path       = $path;
        $this->parameters = $parameters;
        $this->cookies    = $cookies;
    }

    /**
     * @param StateData $stateData
     */
    public function setStateData(StateData $stateData)
    {
        $this->stateData = $stateData;
    }

    /**
     * @return bool
     */
    public function isGetRequest()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        return false;
    }

    /**
     * @return Path
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * @param $name
     *
     * @return Parameter
     */
    public function parameter($name)
    {
        if (!$this->hasParameter($name)) {
            throw new NotFoundInCollectionException('There is no parameter named:' . $name);
        }

        return $this->parameters->getElementByIdentifier(new ParameterIdentifier($name));
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasParameter($name)
    {
        return $this->parameters->hasParameter($name);
    }

    /**
     * @return SessionId
     */
    public function sessionId()
    {
        if (empty($this->sessionId)) {
            $this->sessionId = SessionId::fromRequest($this);
        }

        return $this->sessionId;
    }

    /**
     * @return StateData
     */
    public function stateData()
    {
        return $this->stateData;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasCookie($name)
    {
        return $this->cookies->hasParameter($name);
    }

    /**
     * @param $name
     * @return Parameter
     */
    public function cookie($name)
    {
        if (!$this->hasCookie($name)) {
            throw new NotFoundInCollectionException('There is no cookie named:' . $name);
        }

        return $this->cookies->value($name);
    }

    /**
     * @return ParameterCollection
     */
    public function parameters()
    {
        return $this->parameters;
    }
}
