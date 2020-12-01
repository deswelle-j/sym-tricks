<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Doctrine\Persistence\ObjectManager;
use App\Security\LoginFormAuthenticator;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginFormAuthenticatorTest extends TestCase
{

    public function testExceptionThrowWhenTokenIsInvalid()
    {
        $csrfTokenManager = $this->getMockBuilder(CsrfTokenManagerInterface::class)
            ->getMockForAbstractClass();
        $csrfTokenManager->method('isTokenValid')->willReturn(false);
        $urlGenerator = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->getMockForAbstractClass();
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $passwordEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)
        ->getMockForAbstractClass();
        
        $loginFormAuth = new LoginFormAuthenticator($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder);
        $credentials = [
            'username' => 'usernametest',
            'password' => '1234',
            'csrf_token' => '_csrf_token',
        ];

        $userProvider = $this->getMockBuilder(UserProviderInterface::class)
            ->getMockForAbstractClass();

        $this->expectException(InvalidCsrfTokenException::class);

        $loginFormAuth->getUser($credentials, $userProvider);
    }

    public function testExceptionThrowWhenUsernameCouldNotBeFound()
    {
        $csrfTokenManager = $this->getMockBuilder(CsrfTokenManagerInterface::class)
            ->getMockForAbstractClass();

        $csrfTokenManager->method('isTokenValid')->willReturn(true);

        $urlGenerator = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->getMockForAbstractClass();

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $passwordEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)
            ->getMockForAbstractClass();
        $loginFormAuth = new LoginFormAuthenticator($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder);
        $credentials = [
            'username' => 'usernametest',
            'password' => '1234',
            'csrf_token' => '_csrf_token',
        ];

        $user = new User();
        $user->setHash($credentials['password']);
        $user->setToken($credentials['csrf_token']);

        $userProvider = $this->getMockBuilder(UserProviderInterface::class)
            ->getMockForAbstractClass();

        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('findOneBy')
            ->willReturn(null);
        
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);

        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Username could not be found');

        $loginFormAuth->getUser($credentials, $userProvider);    
    }

    public function testExceptionThrowWhenUsernameIsNotValidate()
    {
        $csrfTokenManager = $this->getMockBuilder(CsrfTokenManagerInterface::class)
            ->getMockForAbstractClass();

        $csrfTokenManager->method('isTokenValid')->willReturn(true);

        $urlGenerator = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->getMockForAbstractClass();

        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $passwordEncoder = $this->getMockBuilder(UserPasswordEncoderInterface::class)
            ->getMockForAbstractClass();
        $loginFormAuth = new LoginFormAuthenticator($entityManager, $urlGenerator, $csrfTokenManager, $passwordEncoder);
        $credentials = [
            'username' => 'usernametest',
            'password' => '1234',
            'csrf_token' => '_csrf_token',
        ];

        $user = new User();
        $user->setHash($credentials['password']);
        $user->setToken($credentials['csrf_token']);

        $userProvider = $this->getMockBuilder(UserProviderInterface::class)
            ->getMockForAbstractClass();

        $userRepository = $this->createMock(ObjectRepository::class);
        $userRepository->expects($this->any())
            ->method('findOneBy')
            ->willReturn($user);
        
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($userRepository);

        $this->expectException(CustomUserMessageAuthenticationException::class);
        $this->expectExceptionMessage('Username is not validate');

        $loginFormAuth->getUser($credentials, $userProvider);
    }
}
