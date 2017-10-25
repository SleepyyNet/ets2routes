<?php
/**
 *  Copyright Christophe Daloz - De Los Rios, 2017
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the “Software”), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  The Software is provided “as is”, without warranty of any kind, express or
 *  implied, including but not limited to the warranties of merchantability,
 *  fitness for a particular purpose and noninfringement. In no event shall the
 *  authors or copyright holders be liable for any claim, damages or other liability,
 *  whether in an action of contract, tort or otherwise, arising from, out of or in
 *  connection with the software or the use or other dealings in the Software.
 */

namespace App\Kernel\QBuilder;

use DI\Container;

class Repository
{
    /**
     * @var QBuilder
     */
    protected $builder;

    protected $json;
    protected $name;
    protected $select;
    protected $class;

    public function __construct(QBuilder $builder, string $class)
    {
        $this->class = $class;
        $this->builder = $builder;

        $pos = strrpos($class, '\\');
        $this->name = substr($class, $pos+1);

        $this->json = json_decode(file_get_contents('App/Config/Entity/'.$this->name.'.json'), true);
        $this->select = $this->builder->select($this->json[$this->name]['name']);
    }

    /**
     * Find one row by ID field
     * @param int $id
     * @return object|bool
     */
    public function find(int $id)
    {
        $this->addedAllFields();

        $this->select
            ->addWhere('id', $id)
            ->execute();
        $result = $this->select->fetch();

        if (!empty($result)) {
            return $this->arrayToEntity($result, new $this->class());
        }

        return false;
    }

    /**
     * Find all row
     * @return array|bool
     */
    public function findAll()
    {
        $this->addedAllFields();

        $this->select->execute();
        $result = $this->select->fetchAll();
        $array = [];

        if (!empty($result)) {
            foreach ($result as $item) {
                $array[] = $this->arrayToEntity($item, new $this->class());
            }

            return $array;
        }

        return false;
    }

    /**
     * Find one row bt selected fields
     * @param array $data
     * @return bool|object
     */
    public function findOneBy(array $data)
    {
        $this->addedAllFields();

        foreach ($data as $field => $value) {
            $this->select->addWhere($field, $value);
        }

        $this->select->execute();
        $result = $this->select->fetch();

        if (!empty($result)) {
            return $this->arrayToEntity($result, new $this->class());
        }

        return false;
    }

    /**
     * Find by selected fields
     * @param array $data
     * @return array|bool
     */
    public function findBy(array $data)
    {
        $this->addedAllFields();

        foreach ($data as $field => $value) {
            $this->select->addWhere($field, $value);
        }

        $this->select->execute();
        $result = $this->select->fetchAll();
        $array = [];

        if (!empty($result)) {
            foreach ($result as $item) {
                $array[] = $this->arrayToEntity($item, new $this->class());
            }

            return $array;
        }

        return false;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 9) == 'findOneBy') {
        }
    }

    /**
     * Convert input array to entity
     * @param array $result
     * @param $entity A instance of entity
     * @return object
     */
    private function arrayToEntity(array $result, $entity)
    {
        foreach ($this->json[$this->name]['entity'] as $property => $field) {
            $method = 'set'.ucfirst($property);
            $entity->$method($result[$field['name']]);
        }

        return $entity;
    }

    /**
     * Add all fields
     */
    private function addedAllFields()
    {
        foreach ($this->json[$this->name]['entity'] as $property => $field) {
            $this->select->addField($field['name']);
        }
    }
}
