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

class Select implements SelectInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \PDOStatement
     */
    private $statement;

    private $tableName;
    private $fields;
    private $clauses;
    private $values;

    /**
     * Select constructor.
     * @param \PDO $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, string $tableName)
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    /**
     * Add field in fields list
     * @param string $fieldName
     * @param string $table
     * @param string $as
     * @return Select
     */
    public function addField(string $fieldName, string $table = '', string $as = ''): self
    {
        $this->fields[$fieldName] = ['table' => $table, 'as' => $as];

        return $this;
    }

    /**
     * Set table name
     * @param string $tableName
     * @return Select
     */
    public function setTable(string $tableName): self
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * Add a WHERE clause
     * @param string $fieldName
     * @param string $value
     * @param string $table
     * @return Select
     */
    public function addWhere(string $fieldName, $value, string $table = ''): self
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
     * Prepared query string
     * @return string
     */
    public function debugQuery()
    {
        return $this->statement->queryString;
    }

    /**
     * Construct an SQL query
     * @return string
     */
    private function sql(): string
    {
        $fields = '';
        $where = [];

        foreach ($this->fields as $name => $data) {
            /*
             * Fields construction list
             */
            if (!empty($data['table'])) {
                if ($name === '*') {
                    $fields .= $name;
                } else {
                    $fields .= sprintf('`%s`.`%s`', $data['table'], $name);
                }
            } else {
                if ($name === '*') {
                    $fields .= $name;
                } else {
                    $fields .= sprintf('`%s`', $name);
                }
            }

            if (!empty($data['as'])) {
                $fields .= sprintf(' AS `%s`', $data['as']);
            }

            $fields .= ', ';
        }

        $where = [];

        /*
         * Where construct array
         */
        if (!empty($this->clauses)) {
            foreach ($this->clauses as $name => $data) {
               // if (!empty($data['value'])) {
                if (!empty($data['table'])) {
                    $where[] = sprintf('`%s`.`%s` = ?', $data['table'], $name);
                } else {
                    $where[] = sprintf('`%s` = ?', $name);
                }
                //}

                //if (!empty($data['value'])) {
                    $this->values[] = $data['value'];
                //}
            }
        }

        $fields = substr($fields, 0, -2);

        $sql = sprintf('SELECT %s FROM `%s`', $fields, $this->tableName);

        if (!empty($where)) {
            $clause = implode(' AND ', $where);
            $sql .= sprintf(' WHERE %s', $clause);
        }

        $sql .= ';';

        return $sql;
    }

    /**
     * Fetches the next row
     * @param int $style
     * @return array|bool
     */
    public function fetch($style = \PDO::FETCH_ASSOC)
    {
        return $this->statement->fetch($style);
    }

    /**
     * Returns an array containing all of the rows
     * @param int $style
     * @return array
     */
    public function fetchAll($style = \PDO::FETCH_ASSOC): array
    {
        return $this->statement->fetchAll($style);
    }
}
