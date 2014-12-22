<?php

namespace ChatBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Client;


class ChatTestCase extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Application
     */
    protected static $application;

    /**
     * @var Client
     */
    protected static $client;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        if (null !== self::$kernel) {
            return;
        }

        static::$client = static::createClient(array(
            'environment' => 'test',
            'debug' => true,
        ));

        $this->container = static::$kernel->getContainer();

        $this->deleteDatabase();

        self::runCommand('doctrine:migrations:migrate');
        self::runCommand('doctrine:fixtures:load');

        parent::setUp();
    }

    /**
     * Deletes the test database.
     */
    protected function deleteDatabase()
    {
        $kernel_root_dir = $this->container->getParameter('kernel.root_dir');
        $absolute_path = realpath("{$kernel_root_dir}/../db/test.db3");

        if (!file_exists($absolute_path)) {
            return;
        }

        $fs = new Filesystem();
        $fs->remove($absolute_path);
    }

    /**
     * Runs the given command.
     *
     * @param $command string
     * @return int
     */
    protected static function runCommand($command)
    {
        $command = sprintf('%s --env=test --no-interaction', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    /**
     * Creates or returns a Symfony Application.
     *
     * @return Application
     */
    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }
}
