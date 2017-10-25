<?php
/**
 *  Copyright Christophe Daloz - De Los RIos, 2017
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

use App\Entity\User;
use App\Kernel\QBuilder\QBuilder;
use App\Kernel\QBuilder\Repository;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    private $repos;
    private $pdo;
    private $builder;

    public function setUp()
    {
        $sql = file_get_contents('Tests/App/Fixtures/user.sql');
        $config = json_decode(file_get_contents(dirname(__FILE__).'/database.json'), true);

        $this->pdo = new \PDO(
            'mysql:dbname='.$config['dbname'].';host=localhost',
            $config['user'],
            $config['password']
        );
        $this->pdo->query($sql)->execute();
        $this->builder = new QBuilder($this->pdo);

        $this->repos = new Repository($this->builder, User::class);
    }

    public function testFind()
    {
        $user = $this->repos->find(1);
        $this->assertInstanceOf(User::class, $user);
    }

    public function testFindAll()
    {
        $users = $this->repos->findAll();

        foreach ($users as $user) {
            $this->assertInstanceOf(User::class, $user);
        }
    }

    public function testFindOneRegisterDateAndValidate()
    {
        $array = ['register_date' => '2017-10-23', 'validate' => 0];
        $user = $this->repos->findOneBy($array);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('2', $user->getId());
        $this->assertEquals('0', $user->getValidate());
        $this->assertEquals('2', $user->getUserGroup());
        $this->assertEquals('test2@test.com', $user->getMail());
    }

    public function testNotFindOne()
    {
        $array = ['register_date' => '2017-10-20', 'validate' => 0];
        $this->assertFalse($this->repos->findOneBy($array));
    }

    public function testFindByUserGroupAndValidateOneRow()
    {
        $array = ['user_group' => 1, 'validate' => 0];
        $users = $this->repos->findBy($array);
        $this->assertCount(1, $users);

        $this->assertInstanceOf(User::class, $users[0]);
        $this->assertEquals(3, $users[0]->getId());
        $this->assertEquals(1, $users[0]->getUserGroup());
        $this->assertEquals(null, $users[0]->getValidationCode());
    }

    public function testNotFindBy()
    {
        $array = ['user_group' => 0];
        $users = $this->repos->findBy($array);
        $this->assertFalse($users);
    }
}
