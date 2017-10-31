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

class EntityManager
{
    /**
     * @var QBuilder
     */
    private $builder;

    private $def;

    public function __construct(\PDO $pdo)
    {
        $this->builder = new QBuilder($pdo);
    }

    /**
     * Execute the save or update entity in DB
     * @param $entity
     * @return bool
     */
    public function execute($entity)
    {
        $this->definitionFile(get_class($entity));

        if (!is_null($entity->getId())) {
            $bool = $this->update($entity);
        } else {
            $bool = $this->save($entity);
        }

        $this->def = null;

        return $bool;
    }

    /**
     * Save entity in DB
     * @param $entity
     * @return bool
     */
    public function save($entity)
    {
        $insert = $this->builder->insert($this->def['name']);

        foreach ($this->def['entity'] as $field => $data) {
            $method = 'get'.ucfirst($field);
            $insert->addField($data['name'], $entity->$method());
        }

        return $insert->execute();
    }

    /**
     * Update entity in DB
     * @param $entity
     * @return bool
     */
    public function update($entity)
    {
        $update = $this->builder->update($this->def['name']);

        foreach ($this->def['entity'] as $field => $data) {
            $method = 'get'.ucfirst($field);
            $update->addField($data['name'], $entity->$method());
        }

        return $update->execute();
    }

    /**
     * @param string $entity
     * @return Repository
     */
    public function getRepository(string $entity)
    {
        $pos = strrpos($entity, '\\');
        $class = substr($entity, $pos+1);

        if (file_exists('App/Repositories/'.$class.'.php')) {
            $repository = 'App\\Repositories\\'.$class;
        } else {
            $repository = 'App\\Kernel\\Qbuilder\\Repository';
        }

        return new $repository($this->builder, $entity);
    }

    /**
     * @param string $className
     */
    private function definitionFile(string $className)
    {
        $file = basename($className);
        $this->def = json_decode(file_get_contents('App/Config/Entity/'.$file.'.json'), true)[$file];
    }
}
