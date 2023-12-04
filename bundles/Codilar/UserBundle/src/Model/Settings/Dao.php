<?php

namespace Codilar\UserBundle\Model\Settings;

use Pimcore\Model\Dao\AbstractDao;
use Pimcore\Model\Exception\NotFoundException;

class Dao extends AbstractDao
{

    protected string $tableName = 'settings_store';

    /**
     * get settings by id
     *
     * @throws \Exception
     */
    public function getById(?string $id = null): void
    {
        if ($id !== null) {
            $this->model->setId($id);
        }

        $data = $this->db->fetchAssociative('SELECT * FROM ' . $this->tableName . ' WHERE id = ?', [$this->model->getId()]);

        if (!$data) {
            throw new NotFoundException("Object with the ID " . $this->model->getId() . " doesn't exist");
        }

        $this->assignVariablesToModel($data);
    }
    // public function getById(?int $id = null): void
    // {
    //     if ($id !== null)  {
    //         $this->model->setId($id);
    //     }

    //     $data = $this->db->fetchAssociative('SELECT * FROM '.$this->tableName.' WHERE id = ?', [$this->model->getId()]);

    //     if(!$data) {
    //         throw new NotFoundException("Object with the ID " . $this->model->getId() . " doesn't exists");
    //     }

    //     $this->assignVariablesToModel($data);
    // }


    /**
     * save settings
     */
    public function save(): void
    {
        // \Pimcore\Logger::info('Generated SQL Query:', [
        //     'sql' => $this->db->getSQL(),
        //     'params' => $this->db->getParams(),
        // ]);

        $vars = get_object_vars($this->model);

        $buffer = [];

        $validColumns = $this->getValidTableColumns($this->tableName);

        if (count($vars)) {
            foreach ($vars as $k => $v) {
                if (!in_array($k, $validColumns)) {
                    continue;
                }

                $getter = "get" . ucfirst($k);

                if (!is_callable([$this->model, $getter])) {
                    continue;
                }

                $value = $this->model->$getter();

                if ($value instanceof \DateTime) {
                    // Convert DateTime to a suitable format, e.g., 'Y-m-d H:i:s'
                    $value = $value->format('Y-m-d H:i:s');
                } elseif (is_bool($value)) {
                    $value = (int) $value;
                }

                $buffer[$k] = $value;
            }
        }

        if ($this->model->getId() !== null) {
            $this->db->update($this->tableName, $buffer, ["id" => $this->model->getId()]);
            return;
        }

        $this->db->insert($this->tableName, $buffer);
        $this->model->setId($this->db->lastInsertId());
    }

    /**
     * delete settings
     */
    public function delete(): void
    {
        $this->db->delete($this->tableName, ["id" => $this->model->getId()]);
    }

}