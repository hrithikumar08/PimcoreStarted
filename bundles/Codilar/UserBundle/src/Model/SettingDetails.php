<?php

namespace Codilar\UserBundle\Model;

use Pimcore\Model\AbstractModel;
use Pimcore\Model\Exception\NotFoundException;

class SettingDetails extends AbstractModel
{
    public $id;
    public $scope;
    public $data;
    public $type;

    public static function getById(?string $id): ?self
    {
        try {
            $obj = new self;
            $obj->getDao()->getById($id);
            return $obj;
        } catch (NotFoundException $ex) {
            \Pimcore\Logger::warn("User with id $id not found");
        }

        return null;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(?string $scope): void
    {
        $this->scope = $scope;
    }
    public function getData(): ?string
    {
        return $this->data;
    }

    public function setData(?string $data): void
    {
        $this->data = $data;
    }
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }


        // public static function getById(string $id): ?self
    // {
    //     try {
    //         $obj = new self;
    //         $obj->getDao()->getById($id);
    //         return $obj;
    //     } catch (NotFoundException $ex) {
    //         \Pimcore\Logger::warn("User with id $id not found");
    //     }

    //     return null;
    // }
}