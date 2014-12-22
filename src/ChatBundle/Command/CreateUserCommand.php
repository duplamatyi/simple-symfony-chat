<?php

namespace ChatBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ChatBundle\Entity\User;

class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('chat:user:create')
            ->setDescription('Creates a chat user.')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');

        $existing_users = $this->getContainer()->get('doctrine')->getRepository('ChatBundle:User')
            ->findBy(array('username' => $username));

        if (!empty($existing_users)) {
            throw new \LogicException("The username \"{$username}\" is already in use.");
        }

        $user = new User();
        $user->setUsername($username);
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $output->writeln("Succesfully created user with username {$username}.");
    }
}
