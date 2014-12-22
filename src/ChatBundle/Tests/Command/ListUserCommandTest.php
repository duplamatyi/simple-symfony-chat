<?php

namespace ChatBundle\Tests\Command;

use ChatBundle\Tests\ChatTestCase;
use Symfony\Component\Console\Tester\CommandTester;


class ListUserCommandTest extends ChatTestCase
{
    /**
     * The chat:user:list should return the 0 status code.
     */
    public function testCreateUserSuccess()
    {
        $application = static::getApplication();
        $command = $application->find('chat:user:list');
        $commandTester = new CommandTester($command);
        $status_code = $commandTester->execute(array('command' => $command->getName()));
        $this->assertEquals($status_code, 0);
        $this->assertRegExp('/1  | user1/', $commandTester->getDisplay());
        $this->assertRegExp('/2  | user2/', $commandTester->getDisplay());
    }
}
