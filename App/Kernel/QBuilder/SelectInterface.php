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

interface SelectInterface
{
    /**
     * Select constructor.
     * @param \PDO $pdo
     * @param string $tableName
     */
    public function __construct(\PDO $pdo, string $tableName);

    /**
     * Add field in fields list
     * @param string $fieldName
     * @param string $table
     * @param string $as
     * @return Select
    */
    public function addField(string $fieldName, string $table = '', string $as = '');

    /**
     * Set table name
     * @param string $tableName
     * @return Select
     */
    public function setTable(string $tableName);

    /**
     * Add a WHERE clause
     * @param string $fieldName
     * @param string $value
     * @param string $table
     * @return Select
     */
    public function addWhere(string $fieldName, $value, string $table = '');

    /**
     * Add a join
     * @param string $type
     * @param string $tableName
     * @param string $field1
     * @param string $tableName2
     * @param string $field2
     * @return Select
     */
    public function addJoin(string $type, string $tableName, string $field1, string $tableName2, string $field2);

    /**
     * Execute query
     * @return bool
     */
    public function execute(): bool;

    /**
     * @return \Exception
     * @throws \Exception
     */
    public function error(): \Exception;

    /**
     * Prepared query string
     * @return string
     */
    public function debugQuery();

    /**
     * Fetches the next row
     * @param int $style
     * @return array|bool
     */
    public function fetch($style = \PDO::FETCH_ASSOC);

    /**
     * Returns an array containing all of the rows
     * @param int $style
     * @return array
     */
    public function fetchAll($style = \PDO::FETCH_ASSOC): array;
}
