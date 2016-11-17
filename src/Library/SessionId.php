<?php
namespace Kartenmacherei\HttpFramework\Library;

use InvalidArgumentException;
use Kartenmacherei\HttpFramework\Request\Request;

class SessionId
{
    /**
     * @var null|string
     */
    private $id;

    /**
     * @var null|string
     */
    private $originalId;

    /**
     * @var string
     */
    private static $cookieName = 'sId';

    /**
     * @param null|string $idString
     */
    public function __construct($idString = null)
    {
        if ($idString === null) {
            $idString = $this->createNewIdentifier();
        }
        $this->ensureIsString($idString);

        $this->originalId = $idString;
        $this->id         = $idString;
    }

    private function ensureIsString($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException;
        }
    }

    /**
     * @return null|string
     */
    public function asString()
    {
        return (string) $this->id;
    }

    /**
     * @return string
     */
    public function getCookieName()
    {
        return self::$cookieName;
    }

    /**
     * @return string
     */
    public function getOriginalId()
    {
        return $this->originalId;
    }

    /**
     * @param Request $request
     * @return SessionId
     */
    public static function fromRequest(Request $request)
    {
        if ($request->hasCookie(self::$cookieName)) {
            $idString = $request->cookie(self::$cookieName)->value();
        } else {
            $idString = null;
        }

        return new self($idString);
    }

    /**
     * @return string
     */
    private function createNewIdentifier()
    {
        return sha1(
            uniqid('session', true) . file_get_contents('/dev/urandom', null, null, null, 42)
        );
    }

    public function regenerate()
    {
        $this->id = sha1(
            uniqid('session', true) . file_get_contents('/dev/urandom', null, null, null, 42)
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asString();
    }
}
