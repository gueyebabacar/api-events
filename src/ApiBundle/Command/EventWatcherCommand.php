<?php

namespace ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EventWatcherCommand extends ContainerAwareCommand

{
    protected function configure()
    {
        $this
            ->setName('api:event_watcher')
            ->setDescription('Set event status to archived when end date is lower than date now.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
       if($this->getContainer()->get('api.event_watcher')->watcher()){
           $output->writeln('Event status changed');
       }
    }
}