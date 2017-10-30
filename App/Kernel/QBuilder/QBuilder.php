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

class QBuilder implements QueryBuilderInterface
{

    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $tableName
     * @return InsertInterface
     */
    public function insert(string $tableName): InsertInterface
    {
        return new Insert($this->pdo, $tableName);
    }

    /**
     * @param string $tableName
     * @return SelectInterface
     */
    public function select(string $tableName): SelectInterface
    {
        return new Select($this->pdo, $tableName);
    }

    /**
     * @param string $tableName
     * @return UpdateInterface
     */
    public function update(string $tableName): UpdateInterface
    {
        return new Update($this->pdo, $tableName);
    }
}
