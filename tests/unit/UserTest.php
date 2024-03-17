<?php

namespace App\Tests;

use App\Entity\User;

use PHPUnit\Framework\TestCase;

class UserUnitTest extends TestCase
{
    public function testIsValid(): void
    {
        /* entité avec id, email, roles, password,firstname, lastname, keyfirst, pathtocket*/
        $user = new User();

        $user->setEmail('test@site.com')
            ->setRoles(['ROLE_TEST'])
            ->setPassword('Password#123456')
            ->setFirstname('firstname')
            ->setLastname('lastname')
            ->setKeyfirst('keyfirst')
            ->setPathticket('pathticket');

        $this->assertSame('test@site.com', $user->getEmail());
        $this->assertSame(['ROLE_TEST','ROLE_USER'], $user->getRoles());
        $this->assertSame('Password#123456', $user->getPassword());
        $this->assertSame('firstname', $user->getFirstname());
        $this->assertSame('lastname', $user->getLastname());
        $this->assertSame('keyfirst', $user->getKeyfirst());
        $this->assertSame('pathticket', $user->getPathticket());

    } 

}