<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserVerify;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UserVerifyTest Extends TestCase
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {

        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider tokenToVerify
     */
    public function testTokenVerify($username, $Usertoken, $token)
    {

        $user = new User();
        $user->setUsername($username);
        $user->setToken($Usertoken);

        $userVerify = new UserVerify($this->entityManager);
        $result = $userVerify->tokenVerify($username, $user, $token);

        $this->assertTrue($result);
    }

    public function tokenToVerify()
    {
        return [
            ["john", "tokengenerick1204684235", "tokengenerick1204684235"]
        ];
    }

}