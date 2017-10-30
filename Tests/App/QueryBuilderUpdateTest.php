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

namespace AppTest;

use App\Kernel\QBuilder\QBuilder;
use App\Kernel\QBuilder\QueryBuilderInterface;
use PHPUnit\Framework\TestCase;

class QueryBuilderUpdateTest extends TestCase
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var QueryBuilderInterface
     */
    private $builder;

    public function setUp()
    {
        $sql = file_get_contents('Tests/App/Fixtures/update.sql');
        $config = json_decode(file_get_contents(dirname(__FILE__).'/database.json'), true);

        $this->pdo = new \PDO(
            'mysql:dbname='.$config['dbname'].';host=localhost',
            $config['user'],
            $config['password']
        );
        $this->pdo->query($sql)->execute();
        $this->builder = new QBuilder($this->pdo);
    }

    public function testUpdateWithNonArgs()
    {
        $update = $this->builder->update('update');

        $update->addField('value', 'Non args');
        $this->assertTrue($update->execute());
    }

    public function testUpdateWithValueField()
    {
        $update = $this->builder->update('update');

        $update
            ->addField('value', 'Value field')
            ->addWhere('id', 1);
        $this->assertTrue($update->execute());
    }

    public function testUpdateWithKeyField()
    {
        $update = $this->builder->update('update');

        $update
            ->addField('key', 'Key field')
            ->addWhere('id', 1);
        $this->assertTrue($update->execute());
    }
}
