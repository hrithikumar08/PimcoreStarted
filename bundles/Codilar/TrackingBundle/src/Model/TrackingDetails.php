<?php

namespace Codilar\TrackingBundle\Model;

use DateTime;
use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class TrackingDetails extends AbstractModel
{
    public $id;
    public $userId;
    public $login;
    public $logout;
    public $action;
    public $objectId;


    public static function getById(int $id): ?self
    {
        try {
            $obj = new self;
            $obj->getDao()->getById($id);
            return $obj;
        } catch (NotFoundException $ex) {
            \Pimcore\Logger::warn("TrackingDetails with id $id not found");
        }

        return null;
    }


    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getLogin(): ?DateTime
    {
        return $this->login;
    }

    public function setLogin($login): void
    {
        if ($login instanceof \DateTime) {
            $this->login = $login;
        } elseif (is_string($login)) {
            $this->login = new \DateTime($login);
        } else {
            $this->login = null;
        }
    }

    public function getLogout(): ?DateTime
    {
        return $this->logout;
    }

    public function setLogout($logout): void
    {
        if ($logout instanceof \DateTime) {
            $this->logout = $logout;
        } elseif (is_string($logout)) {
            $this->logout = new \DateTime($logout);
        } else {
            $this->logout = null;
        }
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): void
    {
        $this->objectId = $objectId;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}


