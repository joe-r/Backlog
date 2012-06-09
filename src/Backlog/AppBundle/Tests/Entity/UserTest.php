<?php

namespace Backlog\AppBundle\Tests\Entity;

use Backlog\AppBundle\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testSetPassword()
    {
        $encoder = $this->getMock('Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface');
        $encoder
            ->expects($this->exactly(2))
            ->method('encodePassword')
            ->with('foo')
            ->will($this->returnValue('bar'))
        ;

        $user = new User();
        $this->assertNull($user->getSalt(), "Salt is null at the beginning");

        $user->setPassword('foo', $encoder);
        $previousSalt = $user->getSalt();
        $this->assertNotNull($previousSalt, "A salt is generated");
        $this->assertEquals("bar", $user->getPassword(), "Encoded password is stored");

        $user->setPassword('foo', $encoder);
        $salt = $user->getSalt();
        $this->assertNotEquals($previousSalt, $salt, "Salt has changed on set password");
    }
}
