<?php
/**
*
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

class QueryBuilderTest extends TestCase
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
        $config = json_decode(file_get_contents(dirname(__FILE__).'/database.json'), true);

        $this->pdo = new \PDO(
            'mysql:dbname='.$config['dbname'].';host=localhost',
            $config['user'],
            $config['password']
        );
        $this->pdo->exec('TRUNCATE TABLE `user`');
        $this->builder = new QBuilder($this->pdo);
    }

    public function testInsert()
    {
        $insert = $this->builder->insert('user');
        $insert
            ->addField('login', 'Test')
            ->addField('password', hash('sha256', 'test'))
            ->addField('user_group', 1)
            ->addField('mail', 'test@test.com')
            ->addField('register_date', '2017-10-23 11:05:56')
            ->addField('last_login', '2017-10-23 11:06:34');
        $this->assertTrue($insert->execute());
    }

    public function testSelectAll()
    {
        $select = $this->builder->select('select');
        $select
            ->addField('*')
            ->execute();
        $this->assertCount(3, $select->fetchAll());
    }

    public function testSelectById()
    {
        $select = $this->builder->select('select');
        $select
            ->addField('*')
            ->addWhere('id', 1)
            ->execute();
        $array = $select->fetch();
        $this->assertEquals(1, $array['id']);
    }

    public function testSelectByOneField()
    {
        $select = $this->builder->select('select');
        $select
            ->addField('*')
            ->addWhere('field3', 'Test')
            ->execute();
        $array = $select->fetchAll();
        $this->assertCount(3, $array);
    }

    public function testSelectByTwoFields()
    {
        $select = $this->builder->select('select');
        $select
            ->addField('*')
            ->addWhere('field1', 'coucou')
            ->addWhere('field3', 'Test')
            ->execute();
        $array = $select->fetchAll();
        $this->assertCount(1, $array);
        $this->assertEquals(3, $array[0]['id']);
    }
}
