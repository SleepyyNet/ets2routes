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

class Insert implements InsertInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $statement;

    private $table;
    private $fields = [];
    private $values;
    private $query;

    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->table = $tableName;
    }

    /**
     * Add field with value
     *
     * @param string $fieldName
     * @param $value
     * @return Insert
     */
    public function addField(string $fieldName, $value): self
    {
        $this->fields[$fieldName] = $value;

        return $this;
    }

    /**
     * Prepared query string
     * @return string
     */
    public function debugQuery()
    {
        return $this->statement->queryString;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        $this->statement = $this->pdo->prepare($this->sql());
        return $this->statement->execute($this->values);
    }

    /**
     * @return \Exception
     * @throws \Exception
     */
    public function error(): \Exception
    {
        throw new \Exception($this->pdo->errorInfo());
    }

    /**
     * @return string
     */
    private function sql(): string
    {
        $fields = [];
        $values = [];
        $elements = [];

        foreach ($this->fields as $key => $value) {
            $fields[] = '`'.$key.'`';
            $elements[] = '?';

            if (is_bool($value)) {
                $values[] = (int)$value;
            } else {
                $values[] = $value;
            }
        }

        $this->values = $values;

        return sprintf(
            'INSERT INTO `%s` (%s) VALUES(%s)',
            $this->table,
            implode(', ', $fields),
            implode(', ', $elements)
        );
    }
}
