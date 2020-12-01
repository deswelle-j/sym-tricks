<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserVerify;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UserVerifyTest extends TestCase
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
    public function testTokenVerify($userId, $Usertoken, $token)
    {
        $user = $this->getMockBuilder(User::class)
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->getMock();
        $user->method('getId')
             ->willReturn($userId);

        $user->method('getToken')
             ->willReturn($Usertoken);

        $userVerify = new UserVerify($this->entityManager);
        $result = $userVerify->tokenVerify($userId, $user, $token);

        $this->assertTrue($result);
    }

    public function tokenToVerify()
    {
        return [
            ["3", "tokengenerick1204684235", "tokengenerick1204684235"]
        ];
    }
}