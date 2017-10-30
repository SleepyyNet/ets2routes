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

class Update implements UpdateInterface
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
    private $values;

    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->table = $tableName;
    }

    /**
     * Add a field in list
     * @param string $fieldName
     * @param $value
     * @return Update
     */
    public function addField(string $fieldName, $value): self
    {
        $this->fields[$fieldName] = '?';
        $this->values[] = $value;

        return $this;
    }

    /**
     * Add WHERE clause
     * @param string $fieldName
     * @param $value
     * @return Update
     */
    public function addWhere(string $fieldName, $value): self
    {
        $this->clauses[$fieldName]['value'] = $value;

        if (!empty($table)) {
            $this->clauses[$fieldName]['table'] = $table;
        }

        return $this;
    }

    /**
     * Execute query
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
     * Return constructed query
     * @return string
     */
    public function debugQuery(): string
    {
        return $this->statement->queryString;
    }

    /**
     * Construct an SQL query
     * @return string
     */
    private function sql(): string
    {
        $fields = [];
        $where = [];

        foreach ($this->fields as $name => $value) {
            /*
             * Fields construction list
             */
            $fields[] = sprintf('`%s` = %s', $name, $value);
        }

        /*
         * Where construct array
         */
        if (!empty($this->clauses)) {
            foreach ($this->clauses as $name => $data) {
                if (!empty($data['table'])) {
                    $where[] = sprintf('`%s`.`%s` = ?', $data['table'], $name);
                } else {
                    $where[] = sprintf('`%s` = ?', $name);
                }

                $this->values[] = $data['value'];
            }
        }

        $sql = sprintf('UPDATE `%s` SET %s', $this->table, implode(', ', $fields));

        if (!empty($where)) {
            $clause = implode(' AND ', $where);
            $sql .= sprintf(' WHERE %s', $clause);
        }

        $sql .= ';';

        return $sql;
    }
}
