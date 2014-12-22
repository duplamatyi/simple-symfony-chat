<?php

namespace ChatBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Query;

class ListUserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('chat:user:list')
            ->setDescription('List the existing chat users.')
            ->setDefinition(array(
                new InputOption('format', null, InputOption::VALUE_REQUIRED, 'To output route(s) in other formats', 'txt'),
                new InputOption('raw', null, InputOption::VALUE_NONE, 'To output raw route(s)'),
            ));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user_repository = $this->getContainer()->get('doctrine')->getRepository('ChatBundle:User');
        $query = $user_repository->createQueryBuilder('u')->select('u.id', 'u.username')->getQuery();
        $result = $query->getResult(Query::HYDRATE_ARRAY);

        $table = new Table($output);
        $table
            ->setHeaders(array('id', 'username'))
            ->setRows($result);

        $table->render();
    }
}
