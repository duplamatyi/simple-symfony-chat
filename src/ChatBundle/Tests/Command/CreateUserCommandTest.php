<?php

namespace ChatBundle\Tests\Command;

use ChatBundle\Tests\ChatTestCase;
use Symfony\Component\Console\Tester\CommandTester;


class CreateUserCommandTest extends ChatTestCase
{
    /**
     * The chat:user:create should create a new user if the username is not in use.
     */
    public function testCreateUserSuccess()
    {
        $application = static::getApplication();
        $command = $application->find('chat:user:create');
        $commandTester = new CommandTester($command);
        $status_code = $commandTester->execute(array(
            'command' => $command->getName(),
            'username' => 'user3',
        ));

        $this->assertEquals($status_code, 0);
        $this->assertRegExp('/Succesfully created user with username user3./', $commandTester->getDisplay());
    }

    /**
     * If the username is in use the chat:user:create should fail with throwing a LogicException.
     */
    public function testCreateUserWithExistingUsername()
    {
        $application = static::getApplication();
        $command = $application->find('chat:user:create');
        $commandTester = new CommandTester($command);
        $logic_exception_caught = false;
        try {
            $commandTester->execute(array(
                'command' => $command->getName(),
                'username' => 'user1',
            ));
        } catch (\LogicException $e) {
            $logic_exception_caught = true;
        }

        $this->assertTrue($logic_exception_caught);
    }
}
